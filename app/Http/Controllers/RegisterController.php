<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Invitation;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;

class RegisterController extends Controller
{
    public function create(Request $request)
    {
        $invitation = Invitation::where('token', $request->token)
            ->firstOrFail();

        $member = Member::where('email', $request->email)->firstOrFail();

        $user = (new CreateNewUser())->create($request->all());

        $invitation->update(['accepted' => true]);

        $user->email_verified_at = now();

        $user->save();

        $member->user_id = $user->id;
        $member->save();

        Auth::guard('web')->login($user);

        return redirect()->intended(route('dashboard'));
    }


    public function showRegistrationForm(Request $request)
    {
        $token = $request->query('token');
        $invitation = Invitation::where('token', $token)
            ->first();

        if (!$invitation) {
            return redirect('/')->with('error', 'Invalid or expired invitation link.');
        }

        return view('auth.register', compact('token', 'invitation'));
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
