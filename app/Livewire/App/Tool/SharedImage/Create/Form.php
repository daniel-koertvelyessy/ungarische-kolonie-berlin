<?php

namespace App\Livewire\App\Tool\SharedImage\Create;

use App\Livewire\App\Tool\SharedImage\SharedImageForm;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public SharedImageForm $form;

    public function save()
    {
        $image = $this->form->save();

        // Reset oder Weiterleitung nach Upload
        $this->form->reset(); // oder: redirect()->route('...')
        session()->flash('success', 'Bild erfolgreich hochgeladen.');
    }

    public function render(): View
    {
        return view('livewire.app.tool.shared-image.create.form');
    }
}
