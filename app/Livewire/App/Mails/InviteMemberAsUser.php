<?php

namespace App\Livewire\App\Mails;

use App\Mail\InvitationMail;
use App\Models\Membership\Invitation;
use Flux\Flux;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class InviteMemberAsUser extends Component
{
    public $email;

    public function sendInvitation()
    {
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
    }
    public function render()
    {
        return view('livewire.app.mails.invite-member-as-user');
    }
}
