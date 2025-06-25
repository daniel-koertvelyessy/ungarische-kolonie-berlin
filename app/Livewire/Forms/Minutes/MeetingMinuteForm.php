<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Minutes;

use Livewire\Attributes\Validate;
use Livewire\Form;

class MeetingMinuteForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|date')]
    public string $meeting_date = '';

    #[Validate('nullable|string|max:255')]
    public ?string $location = null;

    #[Validate('nullable|date')]
    public ?string $stored_at = null;

    public function init(): void
    {
        $this->title = __('minutes.create.default_title');
        $this->meeting_date = now()->format('Y-m-d');
        $this->location = null;
        $this->stored_at = null;
    }

    protected function messages(): array
    {
        return [
            'title.required' => __('minutes.validation_error.title.required'),
            'meeting_date.required' => __('minutes.validation_error.meeting_date.required'),
        ];
    }
}
