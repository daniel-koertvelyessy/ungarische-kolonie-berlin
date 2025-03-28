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
            // Store the uploaded image in the 'public' disk (storage/app/public/)
            $path = $this->image->store('images', 'public');

            // Get the correct absolute path
            $absolutePath = Storage::disk('public')->path($path);
            Log::debug('absolutePath : '.$absolutePath);

            // Debug: Check if the file exists
            if (! file_exists($absolutePath)) {
                Log::error('File not found at: '.$absolutePath);
            }

            // Initialize ImageManager with GD driver
            $manager = new ImageManager(new Driver);

            try {
                // Read the image file
                $image = $manager->read($absolutePath);

                // Define the thumbnail path
                $thumbnailDir = Storage::disk('public')->path('thumbnails');
                $thumbnailPath = $thumbnailDir.'/'.basename($path);

                // Ensure the thumbnails directory exists
                if (! file_exists($thumbnailDir)) {
                    mkdir($thumbnailDir, 0755, true);
                }

                // Resize and save the thumbnail
                $image->scale(width: 150, height: 150);
                $image->save($thumbnailPath);

                // Store the public URL for the thumbnail
                $this->thumbnail = asset('storage/thumbnails/'.basename($path));

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
