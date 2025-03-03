<?php

namespace App\Livewire\App\Tool\Index;

use App\Livewire\Traits\HasPrivileges;
use App\Models\Mailinglist;
use App\Models\Membership\Member;
use Livewire\Component;

class Page extends Component
{

    use HasPrivileges;


    public array $subject;
    public array $message;

    public function sendMembersMail()
    {
        $this->checkPrivilege(Mailinglist::class);
        foreach(Member::all() as $member){
            if ($member->email){
                dd($member->email);
            }

        }

    }

    public function render()
    {
        return view('livewire.app.tool.index.page');
    }
}
