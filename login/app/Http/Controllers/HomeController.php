<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    public function redirect()
    {
        $usertype = Auth::user()->usertype;

        if ($usertype == 'guest') {
            return view('dashboard');
        } elseif ($usertype == 'admin' || $usertype == 'superadmin') {
            $users = User::paginate(10);
            return view('admin.home', ['users' => $users]);
        } else {
            return abort(403, 'Unauthorized');
        }
    }

    public function deactivateUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return abort(404, 'User not found');
        }

        $user->status = 'deactivate';

        $user->save();

        return redirect()->back()->with('success', 'User deactivated successfully');
    }

    public function activateUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->status = 'active';
            $user->save();

            return response()->json(['message' => 'User activated successfully'], 200);
        }

        return response()->json(['error' => 'User not found'], 404);
    }
}
