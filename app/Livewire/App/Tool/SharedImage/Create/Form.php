<?php

declare(strict_types=1);

namespace App\Livewire\App\Tool\SharedImage\Create;

use App\Livewire\App\Tool\SharedImage\SharedImageForm;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

final class Form extends Component
{
    use WithFileUploads;

    public SharedImageForm $form;

    public function save(): void
    {
        $image = $this->form->save();

        $this->form->reset();

        session()->flash('success', count($image).' - Bilder erfolgreich hochgeladen.');
    }

    public function render(): View
    {
        return view('livewire.app.tool.shared-image.create.form');
    }
}
