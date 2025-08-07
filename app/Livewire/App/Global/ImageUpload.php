<?php

declare(strict_types=1);

namespace App\Livewire\App\Global;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\WithFileUploads;

final class ImageUpload extends Component
{
    use WithFileUploads;

    public $image;

    public $thumbnail;

    public function updatedImage(): void
    {

        if ($this->image) {
            $image_path = $this->image->store('images', 'public');
            $absolute_path = Storage::disk('public')->path($image_path);
            //            Log::debug('absolutePath : '.$absolute_path);

            if (! file_exists($absolute_path)) {
                Log::error('File not found at: '.$absolute_path);
            }

            $manager = new ImageManager(new Driver);
            try {
                $image = $manager->read($absolute_path);
                $thumbnail_dir = Storage::disk('public')->path('thumbnails');
                $thumbnail_path = $thumbnail_dir.'/'.basename($image_path);

                if (! file_exists($thumbnail_dir)) {
                    mkdir($thumbnail_dir, 0755, true);
                }

                $image->scale(width: 150, height: 150);
                $image->save($thumbnail_path);

                $this->thumbnail = asset('storage/thumbnails/'.basename($image_path));
                //                Log::debug('Dispatching image-uploaded', ['file' => basename($image_path)]);
                $this->dispatch('image-uploaded', file: basename($image_path));
            } catch (Exception $exception) {
                Log::error('Error decoding image: '.$exception->getMessage());
            }
        }

    }

    public function render(): View
    {
        return view('livewire.app.global.image-upload');
    }
}
