<?php

namespace App\Livewire\Member\Create;

use App\Enums\Gender;
use App\Livewire\Forms\MemberForm;
use App\Models\Accounting\Account;
use App\Models\Membership\Member;
use App\Notifications\ApplianceReceivedNotification;
use App\Notifications\NewMemberApplied;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Mail;
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
        $this->form->applied_at = Carbon::now();
    }


    public function checkEmail():void
    {

        $this->nomail = $this->form->email==='';

    }

    public function checkBirthDate():void
    {
        $birthDate = new Carbon($this->form->birth_date);

        if ($birthDate->diffInYears(now()) > Member::$minimumAgeForDeduction){
            $this->form->is_deducted = true;
            $this->form->deduction_reason = 'Älter als '. Member::$minimumAgeForDeduction;
        } else{
            $this->form->is_deducted = false;
            $this->form->deduction_reason = '';
        }
    }

    protected function printApplication(Member $member)
    {

        return redirect(route('members.print_application',['member'=>$member]));

    }

    protected function sendApplication()
    {
        return redirect(route('home'));
    }


    public function store(): void {


        if ($this->application){
            $this->form->validate();
            $this->form->applied_at = Carbon::now();

            $member = $this->form->create();


            Notification::send(Member::getBoardMembers(), new NewMemberApplied($member));

            Notification::send($member, new ApplianceReceivedNotification($member));

            if($this->nomail){
                $this->printApplication($member);
            }

            Flux::toast(
                heading: __('members.apply.submission.success.head'),
                text: __('members.apply.submission.success.msg'),
                variant: 'success',
            );

        } else {

            $this->checkUser();

            $this->form->validate();

            $member = $this->form->create();

            Flux::toast(
                heading: __('members.apply.submission.success.head'),
                text: __('members.apply.submission.success.msg'),
                variant: 'success',
            );

            $this->redirect(route('members.show',['member'=>$member]));
        }




    }
    protected function checkUser(): void
    {
        try {
            $this->authorize('create', Member::class);
        } catch (AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'Sie haben keine Berechtigungen zur Erstellung von Mitgliedern'.$e->getMessage(),
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
