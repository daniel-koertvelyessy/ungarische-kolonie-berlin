<?php

namespace App\Livewire\App\Tool\SharedImage\Index;

use App\Models\SharedImage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Content extends Component
{
    public string $viewMode = 'table';

    public $images;


    public function mount(string $viewMode = 'table'): void
    {
        $this->viewMode = $viewMode;
    }

    public function getImagesProperty()
    {
        $query = SharedImage::query();

        if (! Auth::user()->isBoardMember()) {
            // Nur freigegebene Bilder für normale User
            $query->where('is_approved', true);
        }

        return $query->latest()->get();
    }

    protected $listeners = ['approveImage'];

    public function approveImage(int $id): void
    {
        $image = \App\Models\SharedImage::findOrFail($id);

        if (! auth()->user()->isBoardMember()) {
            abort(403);
        }

        if (! $image->is_approved) {
            $image->update([
                'is_approved' => true,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Replace updated item in images list
            $this->images = $this->images->map(fn ($img) => $img->id === $image->id ? $image : $img);

            $this->dispatch('notify', ['message' => 'Bild wurde freigegeben.']);
        }
    }

    public function render()
    {
        return view('livewire.app.tool.shared-image.index.content');
    }
}
