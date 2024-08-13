<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ], [
            'name.required' => 'Name field is required!',
            'username.required' => 'Email field is required!',
            'username.email' => 'Email must be a valid email address!',
            'username.unique' => 'This email is already taken!',
            'password.required' => 'Password field is required!',
            'password.confirmed' => 'password does not match!'
        ]);

        $create = User::create([
            'name' => $request->name,
            'email' => $request->username,
            'password' => $request->password,
            'role' => 'student'
        ]);
        if ($create) {
            return redirect()->route('login')->with([
                'message' => 'Account created successfully',
                'type' => 'success'
            ]);
        } else {
            return redirect()->route('signup');
        }
    }
    public function signin(Request $request)
    {
        $user = $request->validate([
            'username' => 'required|email',
            'password' => 'required',
        ],[
            'username.required' => 'username is required!',
            'username.email' => 'username must be a valid email',
            'password.required' => 'password is required!',
        ]);
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            return redirect()->route('index');
        } else {
            return back()->with([
                'type' => 'danger',
                'message' => ' Invalid username or password!'
            ]);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function home()
    {
        if (Auth::user()->role == 'admin') {
            $users = User::whereRole('student')->get();
            if ($users) {
                return view('index', compact('users'));
                // return "User";
            }
        } else {
            $date = date('Y-m-d'); // Using only date for the query
            $userId = Auth::user()->id;
            // Check if the attendance record exists for the specific user and date
            $status = Attendance::select('id', 'status')->where('user_id', $userId)
                ->whereDate('created_at', $date)->first();
            if ($status) {
                return view('index', compact('status'));
                // return "If";
            } else {
                // return "else";
                return view('index', compact('status'));
            }
        }
    }
}
