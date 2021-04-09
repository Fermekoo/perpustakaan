<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $user;
    public function __construct(UserRepo $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('user.index');
    }

    public function dataUser()
    {
        $users = $this->user->getAll();
        $data  = DataTables::of($users)->make(true);

        return $data;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->user->create($request);
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', $e->getMessage());
        }

        return redirect()->route('user.index')->with('success',' User created successfully');
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'nullable'
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->user->update($id, $request);
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', $e->getMessage());
        }

        return redirect()->route('user.index')->with('success',' User updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->user->delete($id);
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', $e->getMessage());
        }

        return redirect()->route('user.index')->with('success',' User deleted successfully');
    }
}
