<?php

namespace App\Http\Controllers;

use App\Models\Membership\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaticController extends Controller
{
    public function privacy(): \Illuminate\View\View
    {
        return view('privacy');
    }

    public function imprint(): \Illuminate\View\View
    {
        return view('impressum');
    }

    public function aboutUs(): \Illuminate\View\View
    {
        $team = Member::with(['activeRoles' => function ($query) {
            $query->wherePivot('resigned_at', null);
        }])->get();

        return view('about-us', ['team' => $team]);
    }

    public function rollbackMail(Request $request): \Illuminate\Http\RedirectResponse
    {
        $decrypted = decrypt($request->query('token'));
        [$userId, $oldEmail] = explode('|', $decrypted);

        $user = User::findOrFail($userId);
        $user->update(['email' => $oldEmail]);
        Auth::guard('web')->login($user);

        return redirect('/dashboard')->with('status', 'Email zurückgesetzt.');
    }
}
