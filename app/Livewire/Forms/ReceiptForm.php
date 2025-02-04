<?php

namespace App\Livewire\Forms;

use App\Models\Accounting\Receipt;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class ReceiptForm extends Form
{
    use WithFileUploads;

    public $id;
    public $uuid;
    public $label;
    public $file_name;
    #[Validate]
    public $number;
    public $date;
    public $description;


    public function updateFile()
    {
        $this->validate();

        $uuid = Str::uuid();
        $originalFilename = $this->file_name->getClientOriginalName();
        $extension = $this->file_name->getClientOriginalExtension();
        $newFilename = $uuid.'.'.$extension;

        // Store file
        $path = $this->file_name->storeAs('accounting/receipts', $newFilename, 'local');

        // Store receipt in DB
        return Receipt::create([
            'uuid'        => $uuid,
            'label'       => $this->label,
            'file_name'   => $newFilename,
            'number'      => $this->number,
            'date'        => $this->date,
            'description' => $this->description,
        ]);
    }

    protected function rules(): array
    {
        return [
            'label'       => ['required'],
            'file_name'   => ['required'],
            'number'      => [
                'required', \Illuminate\Validation\Rule::unique('receipts', 'number')
                    ->ignore($this->id)
            ],
            'date'        => ['required', 'date'],
            'description' => ['nullable', 'string'],
        ];
    }

    protected function messages(): array
    {
        return [
            'label.required'     => 'Belegbezeichnung fehlt',
            'file_name.required' => 'Es wurde noch keine Datei ausgewählt',
            'number.unique'      => 'Diese Belegnummer wurde bereits gebucht!',
            'date.required'      => 'Belegdatum fehlt',
        ];
    }
}
