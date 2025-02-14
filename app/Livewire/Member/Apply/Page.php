<?php

namespace App\Livewire\Member\Apply;

use App\Enums\Gender;
use App\Enums\MemberType;
use App\Models\Membership\Member;
use App\Notifications\NewMemberApplied;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Page extends Component
{
protected Member $member;
    public string $locale;

    public bool $is_deducted;
    public string $birth_date;
    #[Validate('required','string')]
    public string $name;
    public string $first_name;
    public string $email;
    public string $phone;
    public string $mobile;
    public string $address;

    public $checkTurnStile;
    public string $locales;
    public string $city;
    public string $zip;
    public string $country;
    public Gender $gender;
    public string $applied_at;
    public string $deduction_reason;


    public bool $nomail = true;
    public string $validation_error='';

    public function mount()
    {
        $this->locale = app()->getLocale();
        $this->country = 'Deutschland';
        $this->gender = Gender::ma;
        $this->email = '';
        $this->deduction_reason = '';
        $this->is_deducted = false;
    }

    public function applyMembership():void
    {

        $this->validate();


        if(! $this->nomail && $this->email===''){

            $this->validation_error = "Nix da";
            $this->modal('validation_error')->show();

        }

        $member = new Member();

        $member->name = $this->name;
        $member->first_name = $this->first_name??null;
        $member->applied_at = now();
        $member->birth_date = $this->birth_date??null;
        $member->email = $this->email??null;
        $member->phone = $this->phone??null;
        $member->mobile = $this->mobile??null;
        $member->city = $this->city??null;
        $member->zip = $this->zip??null;
        $member->address = $this->address??null;
        $member->type = MemberType::AP->value;
        $member->is_deducted = $this->is_deducted;
        $member->deduction_reason = $this->deduction_reason;

        if ($member->save()){
            Flux::toast(
                heading: __('members.apply.submission.success.head'),
                text: __('members.apply.submission.success.msg'),
                variant: 'success',
            );

            $this->member = $member;

            Notification::send(Member::getBoardMembers(), new NewMemberApplied($this->member));

            if($this->nomail){
                $this->printApplication();
            } else {
                $this->sendApplication();
            }

        } else {
            Flux::toast(
                heading: __('members.apply.submission.failed.head'),
                text: __('members.apply.submission.failed.msg'),
                variant: 'danger',
            );
        }



    }


    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.member.apply.page');
    }
}
