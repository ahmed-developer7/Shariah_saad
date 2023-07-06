<?php

namespace App\Http\Controllers;

use App\Models\UserSector;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['name' => "Manage Users"]
        ];
        return view('content.users', ['breadcrumbs' => $breadcrumbs]);
    }

    public function addUser()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/users", 'name' => "Manage Users"], ['name' => "Add User"]
        ];
        $user = [];
        return view('content.add-user', ['user' => $user, 'breadcrumbs' => $breadcrumbs]);
    }

    public function editUser($id)
    {
        if (Auth()->user()->usertype != 'Super Admin' && $id != Auth()->user()->id) {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/users", 'name' => "Manage Users"], ['name' => "Edit User"]
        ];

        $user = User::where('id', $id)->first();
        $user->sectors = UserSector::where('user_id', $id)->pluck('sector_id');
        if ($user) {
            return view('content.add-user', ['user' => $user, 'breadcrumbs' => $breadcrumbs]);
        }
    }

    public function editUserPassword($id)
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/users", 'name' => "Manage Users"], ['name' => "Update Password"]
        ];
        return view('content.update-user-password', ['id' => $id, 'breadcrumbs' => $breadcrumbs]);
    }

    public function updateUserPassword($id, Request $request)
    {
        $user = User::find($id);
        if ($user) {
            if ($request->password != $request->confirm_password) {
                return back()->withErrors(['msg' => 'Password confirmation failed']);
            }
            $user->password = bcrypt($request->password);
            $user->update();
            return redirect('/admin/users');
        }
    }

    public function editPassword()
    {
        $breadcrumbs = [
            ['name' => "Update Password"]
        ];
        return view('content.update-password', ['breadcrumbs' => $breadcrumbs]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth()->user();
        if ($user) {
            $user = User::find($user->id);
            if ($user) {
                if ($request->password != $request->confirm_password) {
                    return back()->withErrors(['msg' => 'Password confirmation failed']);
                }
                if (!Hash::check($request->old_password, $user->password)) {
                    return back()->withErrors(['msg' => 'Old password match failed']);
                }
                $user->password = bcrypt($request->password);
                $user->update();
                return redirect('/admin/users');
            }
        }
    }
}
