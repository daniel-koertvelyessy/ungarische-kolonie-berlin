<?php

namespace App\Livewire\Accounting\Receipt\Create;

use App\Models\Accounting\Receipt;
use Illuminate\Support\Str;
use Livewire\Component;

class Page extends Component
{

    public function updateReceipt($file)
    {
        if ($file instanceof \Livewire\TemporaryUploadedFile) {
            // Generate a unique filename
            $uuid = Str::uuid();
            $originalFilename = $this->receipt_id->getClientOriginalName();
            $extension = $this->receipt_id->getClientOriginalExtension();
            $newFilename = $uuid . '.' . $extension;

            // Store the file in storage/app/accounting/receipts
            $path = $this->receipt_id->storeAs('accounting/receipts', $newFilename, 'local');

            // Save to database (adjust the model/fields as needed)
            $receipt = Receipt::create([
                'uuid' => $uuid,
                'label' => $this->label,
                'file_name' =>  $newFilename,
                'number' => $this->number,
                'date' => $this->date,
                'description' => $this->description,
            ]);

            $this->dispatch('receipt-uploaded', id: $receipt->id);
        }

        return false;
    }


}
