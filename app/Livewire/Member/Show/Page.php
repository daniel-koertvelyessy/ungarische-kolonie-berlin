<?php

namespace App\Livewire\Member\Show;

use App\Enums\MemberType;
use App\Mail\InvitationMail;
use App\Models\Invitation;
use App\Models\Member;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class Page extends Component
{

    public $users;
    public int $newUser = 0;
    public Member $member;
    public int $member_id;

    public string $member_type;

    public $entered_at;
    public $left_at;
    public $is_deducted;
    public $deduction_reason;
    public $birth_date;
    public $applied_at;
    public $verified_at;
    public $name;
    public $first_name;
    public $email;
    public $phone;
    public $mobile;
    public $address;
    public $city;
    public $zip;
    public $country;
    public $user_id;

    public string $linked_user_name;


    public function mount(Member $member): void
    {
        $this->member = $member;
        $this->populate();

        $this->users = User::select('id', 'name')
            ->get();
    }

    protected function populate(): void
    {
        $this->entered_at = optional($this->member->entered_at)->format('Y-m-d');
        $this->left_at = optional($this->member->left_at)->format('Y-m-d');
        $this->deduction_reason = $this->member->deduction_reason;
        $this->is_deducted = $this->member->is_deducted;
        $this->applied_at = $this->member->applied_at;
        $this->verified_at = optional($this->member->verified_at)->format('Y-m-d');
        $this->birth_date = $this->member->birth_date;
        $this->name = $this->member->name;
        $this->first_name = $this->member->first_name;
        $this->email = $this->member->email;
        $this->phone = $this->member->phone;
        $this->mobile = $this->member->mobile;
        $this->address = $this->member->address;
        $this->zip = $this->member->zip;
        $this->city = $this->member->city;
        $this->country = $this->member->country;
        $this->user_id = $this->member->user_id;
        $this->member_type = $this->member->type;

        $get_user = \App\Models\User::find($this->user_id);
        $this->linked_user_name =  $get_user
            ?     $get_user->first_name . ' ' . $get_user->name
            :'Nicht verknüpft';


    }

    public function detachUser(int $userid): void
    {
        if ($this->user_id === $userid) {
            $this->member->user_id = null;
            $this->user_id = null;
            if ($this->member->save()) {
                Flux::toast(
                    heading: __('members.show.detached.success.head'),
                    text: __('members.show.detached.success.msg', ['name' => $this->member->name]),
                    variant: 'success',
                );
            }
        }
    }

    public function attachUser(): void
    {
        if ($this->newUser > 0) {
            $getUser = User::find($this->newUser);
            if ($getUser->id === $this->newUser) {
                $this->member->user_id = $this->newUser;
                if ($this->member->save()) {
                    Flux::toast(
                        heading: __('members.show.attached.success.head'),
                        text: __('members.show.attached.success.msg', ['name' => $getUser->name]),
                        variant: 'success',
                    );
                    $this->user_id = $this->newUser;
                }
            } else {
                Flux::toast(
                    heading: __('members.show.attached.failed.head'),
                    text: __('members.show.attached.failed.msg'),
                    variant: 'danger',
                );
            }
        }
    }

    public function updateMemberData():void
    {
        try {
            $this->authorize('update', $this->member);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'You have no permission to edit this member! '.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }

        $this->member->name = $this->name;
        $this->member->first_name = $this->first_name;
        $this->member->birth_date = $this->birth_date;
        $this->member->address = $this->address;
        $this->member->zip = $this->zip;
        $this->member->city = $this->city;
        $this->member->country = $this->country;

        if ($this->member->save()) {
            Flux::toast(
                heading: __('members.update.success.title'),
                text: __('members.update.success.content'),
                variant: 'success',
            );
        }
    }

    public function updateContactData():void
    {
        try {
            $this->authorize('update', $this->member);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'You have no permission to edit this member! '.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }

        $this->member->email = $this->email;
        $this->member->phone = $this->phone;
        $this->member->mobile = $this->mobile;

        if ($this->member->save()) {
            Flux::toast(
                heading: __('members.update.success.title'),
                text: __('members.update.success.content'),
                variant: 'success',
            );
        }
    }

    public function updateMembershipData():void
    {
        try {
            $this->authorize('update', $this->member);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'You have no permission to edit this member! '.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }

        $this->member->type = $this->member_type;
        $this->member->is_deducted = $this->is_deducted;
        $this->member->deduction_reason = $this->deduction_reason;


        if ($this->member->save()) {
            Flux::toast(
                heading: __('members.update.success.title'),
                text: __('members.update.success.content'),
                variant: 'success',
            );
        }
    }

    public function sendInvitation(): void
    {
        try{
            $this->validate([
                'email' => 'required|email|unique:invitations,email|unique:users,email',
            ]);
            $invitation = Invitation::create([
                'email' => $this->email,
                'token' => Str::random(32),
            ]);

            Mail::to($this->email)->send(new InvitationMail($invitation));

            Flux::toast(
                heading: __('Erfolg'),
                text: __('Einladung verschickt'),
                variant: 'success',
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            Flux::toast(
                heading: __('Fehler'),
                text: __('Wurde nicht verschickt: '. $e->getMessage()),
                variant: 'danger',
            );
        }




    }

    public function render()
    {
        return view('livewire.member.show.page');
    }
}
