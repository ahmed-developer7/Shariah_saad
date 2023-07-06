<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSector;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc');
        if (isset($request->search)) {
            $search = $request->search;
            $users = $users->where(function ($query) use ($search) {
                $query->where('email', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('usertype', 'like', '%' . $search . '%');
            });
        }
        return $users->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty($request)) {
            $user = User::create(
                [
                    'email' => $request->email,
                    'name' => $request->name,
                    'password' => bcrypt($request->password),
                    'nametitle' => 'n/a',
                    'description' => $request->description,
                    'status' => 1,
                    'usertype' => $request->usertype
                ]
            );

            if ($request->sectors != 'undefined') {
                $sectors = explode(',', $request->sectors);
                $user->sectors()->sync($sectors);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!empty($request)) {
            $data = [
                'email' => $request->email,
                'name' => $request->name,
                'description' => $request->description,
                'usertype' => $request->usertype
            ];

            User::where('id', $id)->update($data);

            if ($request->sectors) {
                $user = User::find($id);
                $sectors = explode(',', $request->sectors);
                $user->sectors()->sync($sectors);
            } else {
                UserSector::where('user_id', $id)->delete();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id) {
            User::where('id', $id)->delete();
        }
    }

    public function updateStatus($id)
    {
        if ($id) {
            $user = User::where('id', $id)->first();
            if ($user->status == 1) {
                $user->status = 0;
            } else {
                $user->status = 1;
            }
            $user->update();
        }
    }
}
