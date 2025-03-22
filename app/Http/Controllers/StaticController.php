<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaticController extends Controller
{
    public function imprint(): \Illuminate\View\View
    {
        return view('impressum');
    }

    public function aboutUs(): \Illuminate\View\View
    {

        return view('about-us');
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
