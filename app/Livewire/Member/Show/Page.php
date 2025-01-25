<?php

namespace App\Livewire\Member\Show;

use App\Models\Member;
use App\Models\User;
use Flux\Flux;
use Livewire\Component;

class Page extends Component
{

    public $users;
    public int $newUser = 0;
    public Member $member;
    public int $member_id;


    public $entered_at;
    public $left_at;
    public $is_discounted;
    public $birth_date;
    public $name;
    public $first_name;
    public $email;
    public $phone;
    public $mobile;
    public $address;
    public $city;
    public $country;
    public $user_id;



    public function mount(Member $member):void
    {

        $this->member = $member;
        $this->populate();

        $this->users = User::select('id','name')->get();

    }

    protected function populate(): void{
        $this->entered_at = $this->member->entered_at;
        $this->left_at = $this->member->left_at;
        $this->is_discounted = $this->member->is_discounted;
        $this->birth_date = $this->member->birth_date;
        $this->name = $this->member->name;
        $this->first_name = $this->member->first_name;
        $this->email = $this->member->email;
        $this->phone = $this->member->phone;
        $this->mobile = $this->member->mobile;
        $this->address = $this->member->address;
        $this->city = $this->member->city;
        $this->country = $this->member->country;
        $this->user_id = $this->member->user_id;


    }

    public function detachUser(int $userid): void
    {

        if ($this->user_id === $userid) {
            $this->member->user_id = null;
            $this->user_id = null;
            if ($this->member->save()){
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

        if($this->newUser > 0) {
            $getUser = User::find($this->newUser);
            if ($getUser->id === $this->newUser) {
                $this->member->user_id = $this->newUser;
                if($this->member->save()){
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

    public function render()
    {
        return view('livewire.member.show.page');
    }
}
