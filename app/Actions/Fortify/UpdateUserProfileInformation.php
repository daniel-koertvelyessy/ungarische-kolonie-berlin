<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Notifications\EmailChangeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'first_name' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:20'],
            'locale' => ['nullable', 'string', 'max:2'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')
                ->ignore($user->id),
            ],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])
            ->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email) {
            $oldEmail = $user->email;

            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])
                ->save();
            Notification::send($user, new EmailChangeNotification($oldEmail, $input['email']));

            //            $this->updateVerifiedUser($user, $input);
        } else {
            app()->setLocale($input['locale']);
            session()->put('locale', $input['locale']);
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'first_name' => $input['first_name'],
                'username' => $input['username'],
                'phone' => $input['phone'],
                'mobile' => $input['mobile'],
                'gender' => $input['gender'],
                'locale' => $input['locale'],
            ])
                ->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])
            ->save();

        $user->sendEmailVerificationNotification();
    }
}
