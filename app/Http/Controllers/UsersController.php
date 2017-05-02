<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show(User $user)
    {
        $activities = \App\Activity::feed($user);

        return view('users.show', [
            'user' => $user,
            'activities' => $activities
        ]);
    }
}
