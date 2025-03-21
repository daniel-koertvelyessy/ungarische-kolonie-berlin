<?php

namespace App\Livewire\Forms\Blog;

use App\Actions\Post\CreatePostType;
use App\Actions\Post\UpdatePostType;
use App\Models\Blog\PostType;
use Livewire\Form;

class PostTypeForm extends Form
{
    protected Posttype $postType;

    public $id;

    public array $name = ['de' => '', 'hu' => ''];

    public $slug;

    public $description;

    public $color;

    public PostType $type;

    public function set(int $postId): void
    {
        $this->postType = PostType::query()->findOrFail($postId);
        $this->id = $this->postType->id;
        $this->name = $this->postType->name;
        $this->slug = $this->postType->slug;
        $this->color = $this->postType->color;
        $this->description = $this->postType->description;

    }

    public function create(): PostType
    {
        return CreatePostType::handle($this);
    }

    public function update(): PostType
    {
        return UpdatePostType::handle($this);
    }
}
