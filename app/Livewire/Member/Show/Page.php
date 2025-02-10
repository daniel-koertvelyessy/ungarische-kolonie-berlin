<?php

namespace App\Livewire\Member\Show;

use App\Livewire\Forms\MemberForm;
use App\Mail\InvitationMail;
use App\Models\Invitation;
use App\Models\Member;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class Page extends Component
{

    public $users;
    public int $newUser = 0;
    public Member $member;

    public MemberForm $memberForm;

    public $confirm_deletion_text = '';

    public $hasUser = false;

    public function mount(Member $member): void
    {
        $this->memberForm->set($member);
        $this->users = User::select('id', 'name')
            ->get();
    }


    public function detachUser(int $userid): void
    {
        if ($this->memberForm->user_id === $userid) {
            $this->memberForm->user_id = null;
            if ($this->member->save()) {
                $this->hasUser = false;
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
                $this->memberForm->member->user_id = $this->newUser;
                if ($this->memberForm->member->save()) {
                    $this->hasUser = true;

                    Flux::toast(
                        heading: __('members.show.attached.success.head'),
                        text: __('members.show.attached.success.msg', ['name' => $getUser->name]),
                        variant: 'success',
                    );
                    $this->memberForm->user_id = $this->newUser;
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

    public function updateMemberData(): void
    {
        $this->checkUser();

        if ($this->memberForm->updateData()) {
            Flux::toast(
                heading: __('members.update.success.title'),
                text: __('members.update.success.content'),
                variant: 'success',
            );
        }
    }

    public function updateContactData(): void
    {
        $this->checkUser();

        if ($this->memberForm->updateContact()) {
            Flux::toast(
                heading: __('members.update.success.title'),
                text: __('members.update.success.content'),
                variant: 'success',
            );
        }
    }

    public function updateMembershipData(): void
    {
        $this->checkUser();

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
        try {
            $this->validate([
                'memberForm.email' => 'required|email|unique:invitations,email|unique:users,email',
            ]);

            $invitation = Invitation::create([
                'email' => $this->memberForm->email,
                'token' => Str::random(32),
            ]);


            Mail::to($this->memberForm->email)
                ->send(new InvitationMail($invitation, $this->memberForm->member));

            Flux::toast(
                heading: __('Erfolg'),
                text: __('Einladung verschickt'),
                variant: 'success',
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            Flux::toast(
                heading: __('Fehler'),
                text: __('Wurde nicht verschickt: '.$e->getMessage()),
                variant: 'danger',
            );
        }
    }

    public function cancelMember()
    {
        try {
            $this->authorize('delete', Member::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'You have no permission to edit this member! '.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }

        Flux::modal('delete-membership')
            ->show();
    }

    protected function checkUser(): void
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
    }

    public function deleteMembershipForSure()
    {
        $this->authorize('delete', Member::class);
        $msg = '';
        if ($this->memberForm->user_id){

            if (Auth::user()->id !== $this->memberForm->user_id) {
                $msg = User::find($this->memberForm->user_id)->delete() ? ' Benutzer gelöscht' : ' Fehler beim Löschen des Benutzers ' . $this->memberForm->user_id;
            }



        }

        if ($this->memberForm->cancelMembership()){

            Flux::toast(
                heading: __('Erfolg'),
                text: __('Mitgliedshaft wurde gekündigt'). $msg,
                variant: 'success',
            );
        }

    }

    public function reactivateMembership():void
    {
        $this->authorize('delete', Member::class);

        if ($this->memberForm->reactivateMembership()){

            Flux::toast(
                heading: __('Erfolg'),
                text: __('Mitgliedshaft wurde wiederhergestellt'),
                variant: 'success',
            );
        }

    }

    public function render()
    {
        return view('livewire.member.show.page');
    }
}
