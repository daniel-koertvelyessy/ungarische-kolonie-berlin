<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Membership\Invitation;
use App\Models\Membership\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function create(Request $request)
    {
        $invitation = Invitation::query()
            ->where('token', $request->token)
            ->firstOrFail();

        $member = Member::query()
            ->where('email', $invitation->email)
            ->firstOrFail();

        $user = (new CreateNewUser)->create([
            'locale' => $member->locale,
            'first_name' => $member->first_name,
            'name' => $member->name,
            'email' => $member->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        $invitation->update(['accepted' => true]);

        $user->email_verified_at = now();

        $user->save();

        $member->user_id = $user->id;
        $member->save();

        Auth::guard('web')
            ->login($user);

        return redirect()->intended(route('dashboard'));
    }

    public function showRegistrationForm(Request $request)
    {
        $token = $request->query('token');
        $invitation = Invitation::query()
            ->where('token', $token)
            ->first();

        try {
            $member = Member::query()
                ->where('email', $invitation->email)
                ->firstOrFail();
        } catch (\Exception $exception) {
            Log::alert('Failed attempt to get member by e-mail :'.$invitation->email.' / error: '.$exception->getMessage());

            return redirect('/')->with('error', 'member not found');
        }

        if (! $invitation) {
            Log::alert('Failed due to Invalid or expired invitation');

            return redirect('/')->with('error', 'Invalid or expired invitation link. Requested token: '.$token);
        }

        return view('auth.register-member', compact('token', 'invitation', 'member'));
    }
}
/**
 * $request->validate([
 * 'email' => 'required|email',
 * 'password' => 'required|min:8|confirmed',
 * 'name' => 'required|string',
 * 'token' => 'required|exists:invitations,token'
 * ]);
 *
 * Validator::make($input, [
 * 'name' => ['required', 'string', 'max:255'],
 * 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
 * 'password' => $this->passwordRules(),
 * 'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
 * ])->validate();
 * $user = User::create([
 * 'name' => $request->name,
 * 'email' => $request->email,
 * 'email_verified_at' => now(),
 * 'password' => Hash::make($request->password),
 * ]);
 */
