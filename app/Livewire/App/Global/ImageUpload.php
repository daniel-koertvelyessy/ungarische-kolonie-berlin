<?php

namespace App\Livewire\App\Global;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImageUpload extends Component
{
    use WithFileUploads;

    public $image;

    public $thumbnail;

    public function updatedImage(): void
    {

        if ($this->image) {
            $path = $this->image->store('images', 'public');
            $absolutePath = Storage::disk('public')->path($path);
            Log::debug('absolutePath : '.$absolutePath);

            if (! file_exists($absolutePath)) {
                Log::error('File not found at: '.$absolutePath);
            }

            $manager = new ImageManager(new Driver);
            try {
                $image = $manager->read($absolutePath);
                $thumbnailDir = Storage::disk('public')->path('thumbnails');
                $thumbnailPath = $thumbnailDir.'/'.basename($path);

                if (! file_exists($thumbnailDir)) {
                    mkdir($thumbnailDir, 0755, true);
                }

                $image->scale(width: 150, height: 150);
                $image->save($thumbnailPath);

                $this->thumbnail = asset('storage/thumbnails/'.basename($path));
                Log::debug('Dispatching image-uploaded', ['file' => basename($path)]);
                $this->dispatch('image-uploaded', file: basename($path));
            } catch (Exception $e) {
                Log::error('Error decoding image: '.$e->getMessage());
            }
        }

    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.app.global.image-upload');
    }
}
