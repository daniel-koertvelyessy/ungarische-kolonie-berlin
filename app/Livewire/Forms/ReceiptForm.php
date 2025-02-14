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
    public $transaction_id;
    public $file_name;
    public $file_name_original;

    public function set(Receipt $receipt)
    {
        $this->id = $receipt->id;
        $this->file_name = $receipt->file_name;
    }


    public function generatePreview($filename): string
    {
        $pdfFullPath = storage_path('app/private/accounting/receipts/' . $filename);
        $outputPath = 'accounting/receipts/previews/' . pathinfo($filename, PATHINFO_FILENAME) . '.png';
        $outputFullPath = storage_path('app/private/' . $outputPath);

        // Ensure directory exists
        $outputDir = dirname($outputFullPath);
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        // Detect Ghostscript path
        $gsPath = '/usr/bin/gs'; // Linux default
        if (app()->environment() == 'local') {
            $gsPath = '/opt/homebrew/bin/gs'; // macOS Homebrew
        }
        putenv("MAGICK_GS_DELEGATE=$gsPath");

        try {
            $imagick = new Imagick();
            $imagick->readImage($pdfFullPath . '[0]');
            $w = $imagick->getImageWidth() * 0.3;
            $h = $imagick->getImageHeight() * 0.3;
            $imagick->resizeImage($w, $h, Imagick::FILTER_CATROM, 1);
            $imagick->setResolution(288, 288);
            $imagick->setImageFormat('png');
            $imagick->writeImage($outputFullPath);
            $imagick->clear();
            $imagick->destroy();

            return Storage::url($outputPath);
        } catch (\Exception $e) {
            \Log::error('PDF Preview Error: ' . $e->getMessage());
            return '';
        }
    }

    public function updateFile(int $transaction_id)
    {
        $this->transaction_id = $transaction_id;
        $this->validate();

        $uuid = Str::uuid();
        $originalFilename = $this->file_name->getClientOriginalName();
        $extension = $this->file_name->getClientOriginalExtension();
        $newFilename = $uuid.'.'.$extension;
        // Store file
        $this->file_name->storeAs('accounting/receipts', $newFilename, 'local');

        $path = $this->generatePreview($newFilename);


        // Store receipt in DB
        return Receipt::create([
            'file_name_original' => $originalFilename,
            'file_name'          => $newFilename,
            'transaction_id'     => $transaction_id,
        ]);
    }

    protected function rules(): array
    {
        return [

            'file_name_original' => [
                'nullable', \Illuminate\Validation\Rule::unique('receipts', 'file_name')
                    ->ignore($this->transaction_id)
            ],
            'file_name'        => [
                'required'
            ],
            'transaction_id'   => [
                'required',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'transaction_id.required' => __('The transaction id field is required.'),
            'label.required'          => 'Belegbezeichnung fehlt',
            'file_name.required'      => 'Es wurde noch keine Datei ausgewählt',
            'number.unique'           => 'Diese Belegnummer wurde bereits gebucht!',
            'date.required'           => 'Belegdatum fehlt',
        ];
    }
}
