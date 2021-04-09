<?php 
namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class UserRepo 
{
    public function getAll()
    {
        return User::get();
    }

    public function create($request)
    {
        try {
            $user = User::create([
                'name'      => strip_tags($request->name),
                'email'     => strip_tags($request->email),
                'password'  => Hash::make($request->password,[]),
                'user_type' => 'User'
            ]);
        } catch (QueryException $e) {
            throw $e;
        }

        return $user;
    }

    public function update($id, $request)
    {
        try {
            $user = User::find($id);
            $user->name         = strip_tags($request->name);
            $user->email        = strip_tags($request->email);
            $user->password     = ($request->password) ? Hash::make($request->password,[]) : $user->password;
            $user->save(); 
        } catch (QueryException $e) {
            throw $e;
        }

        return $user;
    }

    public function delete($id)
    {
        return User::where('id',$id)->delete();
    }
}