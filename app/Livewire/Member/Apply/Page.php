<?php

namespace App\Livewire\Member\Apply;

use App\Enums\Gender;
use App\Enums\Locale;
use App\Models\Member;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use RyanChandler\LaravelCloudflareTurnstile\Rules\Turnstile;

class Page extends Component
{

    public string $locale;

    protected Member $member;

    public bool $is_discounted;
    public string $birth_date;
    #[Validate('required','string')]
    public string $name;
    public string $first_name;
    public string $email;
    public string $phone;
    public string $mobile;
    public string $address;

    public string $locales;
    public string $city;
    public string $country;
    public Gender $gender;
    public string $applied_at;
    public string $deduction_reason;

    public bool $printApplication = false;
    public bool $nomail = false;

    public function mount()
    {
        $this->locale = app()->getLocale();
        $this->country = 'Deutschland';
        $this->gender = Gender::ma;
    }

    public function sendApplication()
    {
        request()->validate([
            'cf-turnstile-response' => ['required', app(Turnstile::class)],
        ]);
    }

    public function download()
    {
        return response()->download(
            $this->invoice->file_path, 'invoice.pdf'
        );
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.member.apply.page');
    }
}
