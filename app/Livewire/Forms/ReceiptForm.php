<?php

namespace App\Livewire\Forms;

use App\Models\Accounting\Receipt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Imagick;
use ImagickException;
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


    public function set(Receipt $receipt)
    {
        $this->id = $receipt->id;
        $this->uuid = $receipt->uuid;
        $this->label = $receipt->label;
        $this->file_name = $receipt->file_name;
        $this->number = $receipt->number;
        $this->date = $receipt->date;
        $this->description = $receipt->description;
    }


    public function generatePreview(): string
    {
        if (app()->environment() == 'production') {
            putenv("MAGICK_GS_DELEGATE=/opt/homebrew/bin/gs");
            $pdfFullPath = storage_path('app/private/accounting/receipts/'.$this->file_name);
            $outputPath = 'accounting/receipts/previews/'.pathinfo($this->file_name, PATHINFO_FILENAME).'.png';
            $outputFullPath = storage_path('app/private/'.$outputPath);
            if (file_exists($pdfFullPath)) {
                if (!file_exists($outputFullPath)) {
                    $imagick = new Imagick();
                    $imagick->readImage($pdfFullPath.'[0]'); // Read first page
                    $w = $imagick->getImageWidth() * 0.3;
                    $h = $imagick->getImageHeight() * 0.3;
                    $imagick->resizeImage($w, $h, Imagick::FILTER_CATROM, 1);
                    $imagick->setResolution(288, 288); // Set DPI for better quality
                    $imagick->setImageFormat('png');
                    $imagick->writeImage($outputFullPath);
                    $imagick->clear();
                    $imagick->destroy();
                }
            }
            return Storage::url($outputPath);
        } else {
            $pdfPath = storage_path('app/private/accounting/receipts/'.$this->file_name);
            $outputPath = storage_path('app/private/accounting/receipts/previews/'.pathinfo($this->file_name, PATHINFO_FILENAME).'.png');

            $command = "/opt/homebrew/bin/gs -sDEVICE=pngalpha -o {$outputPath} -r288 {$pdfPath}";
            shell_exec($command);

            return pathinfo($this->file_name, PATHINFO_FILENAME).'.png';
        }
    }

    public function updateFile()
    {
        $this->validate();

        $uuid = Str::uuid();
        $originalFilename = $this->file_name->getClientOriginalName();
        $extension = $this->file_name->getClientOriginalExtension();
        $newFilename = $uuid.'.'.$extension;

        // Store file
        $this->file_name->storeAs('accounting/receipts', $newFilename, 'local');

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
