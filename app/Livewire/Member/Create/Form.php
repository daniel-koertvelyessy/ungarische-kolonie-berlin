<?php

namespace App\Livewire\Member\Create;

use App\Enums\Gender;
use App\Enums\MemberFamilyStatus;
use App\Enums\MemberType;
use App\Livewire\Forms\Member\MemberForm;
use App\Models\Membership\Member;
use App\Notifications\ApplianceReceivedNotification;
use App\Notifications\NewMemberApplied;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class Form extends Component
{
    public MemberForm $form;

    public $application;

    public $nomail;

    public function mount()
    {
        $this->form->locale = app()->getLocale() ?? 'de';
        $this->form->gender = Gender::ma->value;
        $this->form->applied_at = Carbon::now('Europe/Berlin');
        $this->form->family_status = MemberFamilyStatus::NN->value;
        $this->form->type = MemberType::AP->value;
        $this->form->country = 'Deutschland';
    }

    public function checkEmail(): void
    {

        $this->nomail = $this->form->email === '';

    }

    public function checkBirthDate(): void
    {
        $birthDate = new Carbon($this->form->birth_date);

        if ($birthDate->diffInYears(now()) > Member::$age_discounted) {
            $this->form->is_deducted = true;
            $this->form->deduction_reason = 'Älter als '.Member::$age_discounted;
        } else {
            $this->form->is_deducted = false;
            $this->form->deduction_reason = '';
        }
    }

    protected function printApplication(Member $member)
    {

        return redirect(route('members.print_application', ['member' => $member]));

    }

    protected function sendApplication()
    {
        return redirect(route('home'));
    }

    public function store(): void
    {

        if ($this->application) {
            $this->form->validate();
            $this->form->applied_at = Carbon::now('Europe/Berlin');

            $member = $this->form->create();

            Notification::send(Member::getBoardMembers(), new NewMemberApplied($member));

            Notification::send($member, new ApplianceReceivedNotification($member));

            if ($this->nomail) {
                $this->printApplication($member);
            }

            Flux::toast(
                text: __('members.apply.submission.success.msg'),
                heading: __('members.apply.submission.success.head'),
                variant: 'success',
            );

        } else {

            $this->checkUser();

            $this->form->validate();

            $member = $this->form->create();

            Flux::toast(
                text: __('members.apply.submission.success.msg'),
                heading: __('members.apply.submission.success.head'),
                variant: 'success',
            );

            $this->redirect(route('members.show', ['member' => $member]),true);
        }

    }

    protected function checkUser(): void
    {
        try {
            $this->authorize('create', Member::class);
        } catch (AuthorizationException $e) {
            Flux::toast(
                text: 'Sie haben keine Berechtigungen zur Erstellung von Mitgliedern'.$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );

            return;
        }
    }

    public function render()
    {
        return view('livewire.member.create.form');
    }
}
