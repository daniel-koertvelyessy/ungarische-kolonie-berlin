<?php

namespace App\Livewire\Blog\Post;

use App\Enums\EventStatus;
use App\Livewire\Forms\Blog\PostForm;
use App\Livewire\Traits\HasPrivileges;
use App\Livewire\Traits\PersistsTabs;
use App\Models\Blog\Post;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use PersistsTabs, WithFileUploads, HasPrivileges;

    public ?Post $post = null;
    public PostForm $form;
    public $images = [];
    public $newImages = [];
    public $defaultTab = 'post-create-head-section-panel';
    public string $selectedTab;
    public string $tabsBody;

    public bool $editPost = false;
    public $locale;

    public array $captionsDe = []; // Captions in German
    public array $captionsHu = []; // Captions in Hungarian
    public array $authors = [];

    public function mount(?Post $post):void
    {
        $this->locale = app()->getLocale();
        $this->selectedTab = $this->getSelectedTab();
        $this->tabsBody = 'body-de';
        $this->form = new PostForm($this, $post);
        if ($post->id) {
            $this->form->set($post->id);
            $this->post = $post;
            $this->editPost = true;
        } else {
            $this->form->post_type_id = 2;
            $this->form->status = EventStatus::DRAFT;
            $this->form->user_id = auth()->id();
        }
    }

    public function updatedNewImages($value): void
    {
        $this->checkPrivilege(Post::class);

        $this->validate([
            'newImages.*' => 'image|max:10240', // 10MB max per image
        ]);

        // Merge new uploads into the main images array
        if ($this->newImages) {
            $this->images = array_merge($this->images, $this->newImages);
            $this->newImages = []; // Reset for the next upload
        }

        \Log::debug('Images after update: ' . json_encode($this->images));
    }


    public function makeSlugs(): void
    {
        $this->form->slug['de'] = Str::slug($this->form->title['de']);
        $this->form->slug['hu'] = Str::slug($this->form->title['hu']);
    }

    public function save(): void
    {
        $this->checkPrivilege(Post::class);

        $this->validate([
            'form.label' => 'required|string|max:100',
            'form.title.de' => 'required|string|max:100',
            'form.title.hu' => 'required|string|max:100',
            'form.slug.de' => ['required','string','max:255', Rule::unique('posts','slug->de')->ignore($this->form->id)],
            'form.slug.hu' => ['required','string','max:255', Rule::unique('posts','slug->hu')->ignore($this->form->id)],
            'form.body.de' => 'nullable|string',
            'form.body.hu' => 'nullable|string',
            'form.post_type_id' => 'required|exists:post_types,id',
            'form.status' => ['required' , Rule::enum(EventStatus::class)],
            'images.*' => 'nullable|image|max:10240', // 10MB max per image
            'captionsDe.*' => 'nullable|string|max:255',
            'captionsHu.*' => 'nullable|string|max:255',
            'authors.*' => 'nullable|string|max:100',
        ]);

        if ($this->editPost) {
            $post = $this->form->update();
            $this->handleImages($post);
            Flux::toast(text: 'Der Artikel mit '.count($post->images).' Bildern wurde erfolgreich aktualisiert!', heading: 'Erfolg', duration: 8000, variant: 'success');
        } else {
            $post = $this->form->create();
            $this->handleImages($post);
            Flux::toast(text: 'Der Artikel mit '.count($post->images).' Bildern wurde erfolgreich erstelt!', heading: 'Erfolg', duration: 8000, variant: 'success');
        }

    }

    protected function handleImages(Post $post): void
    {
        if ($this->images && count($this->images) > 0) {
            foreach ($this->images as $index => $image) {
                $filename = $image->store('post-images', 'public');
                $post->images()->create([
                    'filename' => $filename,
                    'original_filename' => $image->getClientOriginalName(),
                    'caption' => [
                        'de' => $this->captionsDe[$index] ?? '',
                        'hu' => $this->captionsHu[$index] ?? '',
                    ],
                    'author' => $this->authors[$index] ?? null,
                ]);
            }
        }
    }

    public function addDummyData(): void
    {
        $this->form->label = fake()->realText(50);
        $this->form->title['de'] = fake()->realText(50);
        $this->form->slug['de'] = Str::slug(fake()->realText(50));
        $this->form->body['de'] = fake()->randomHtml(20,8);
        $this->form->title['hu'] = fake()->realText(50);
        $this->form->slug['hu'] = Str::slug(fake()->realTextBetween(20));
        $this->form->body['hu'] = fake()->randomHtml(20,8);

    }

    public function removeImage($index): void
    {
        unset($this->images[$index]);
        unset($this->captionsDe[$index]);
        unset($this->captionsHu[$index]);
        unset($this->authors[$index]);
        $this->images = array_values($this->images);
        $this->captionsDe = array_values($this->captionsDe);
        $this->captionsHu = array_values($this->captionsHu);
        $this->authors = array_values($this->authors);
    }

    public function deleteImage($imageId): void
    {
        $this->checkPrivilege(Post::class);

        if ($this->editPost && $this->post) {
            $image = $this->post->images()->find($imageId);
            if ($image) {
                Storage::disk('public')->delete($image->filename); // Remove file from storage
                $image->delete(); // Remove from database
                $this->post->refresh(); // Reload post to update $post->images
                Flux::toast(text: 'Bild erfolgreich entfernt!', heading: 'Erfolg', duration: 3000, variant: 'success');
            }
        }
    }

    public function render()
    {
        return view('livewire.blog.post.form');
    }
}
