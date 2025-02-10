<?php

namespace App\Livewire\Forms;

use App\Enums\Gender;
use App\Enums\Locale;
use App\Enums\MemberType;
use App\Models\Membership\Member;
use Illuminate\Validation\Rule;
use Livewire\Form;

class MemberForm extends Form
{
    public Member $member;
    public $id;
    public $applied_at;
    public $verified_at;
    public $entered_at;
    public $left_at;
    public $is_deducted;
    public $deduction_reason;
    public $birth_date;
    public $name;
    public $first_name;
    public $email;
    public $phone;
    public $mobile;
    public $address;
    public $zip;
    public $city;
    public $country;
    public $locale;
    public $gender;
    public $type;
    public $user_id;

    public $linked_user_name;


    function set(Member $member): void
    {
        $this->member = $member;
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
        $this->type = $this->member->type;
        $this->linked_user_name = $this->setUser();
    }

    public function setUser()
    {
        $get_user = \App\Models\User::find($this->user_id);
        return $get_user
            ? $get_user->first_name.' '.$get_user->name
            : 'Nicht verknüpft';
    }

    public function updateContact(): bool
    {
        $this->member->email = $this->email;
        $this->member->phone = $this->phone;
        $this->member->mobile = $this->mobile;
        return $this->member->save();
    }


    public function updateData(): bool
    {
        $this->member->name = $this->name;
        $this->member->first_name = $this->first_name;
        $this->member->birth_date = $this->birth_date;
        $this->member->address = $this->address;
        $this->member->zip = $this->zip;
        $this->member->city = $this->city;
        $this->member->country = $this->country;

        return $this->member->save();
    }

    public function cancelMembership(): bool
    {
        $this->member->left_at = now();
        return $this->member->save();
    }
    public function reactivateMembership(): bool
    {
        $this->member->left_at = null;
        return $this->member->save();
    }

    protected function rules(): array
    {
        return [
            'id'               => Rule::unique('members', 'id')
                ->ignore($this->member->id),
            'applied_at'       => 'required|date',
            'verified_at'      => 'nullable',
            'entered_at'       => 'nullable',
            'left_at'          => 'nullable',
            'is_deducted'      => 'nullable',
            'deduction_reason' => 'nullable',
            'birth_date'       => 'nullable',
            'name'             => 'required',
            'first_name'       => 'nullable',
            'email'            => 'nullable',
            'phone'            => 'nullable',
            'mobile'           => 'nullable',
            'address'          => 'nullable',
            'zip'              => 'nullable',
            'city'             => 'nullable',
            'country'          => 'nullable',
            'locale'           => ['nullable', Rule::enum(Locale::class)],
            'gender'           => ['nullable', Rule::enum(Gender::class)],
            'type'             => ['nullable', Rule::enum(MemberType::class)],
            'user_id'          => ['nullable', 'exists:App\Models\User,id'],
        ];
    }

}
