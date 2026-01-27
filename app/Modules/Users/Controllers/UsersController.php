<?php

namespace App\Modules\Users\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\LeaveBalance;
use App\Modules\Settings\Models\Settings;

class UsersController extends Controller
{
    public function index()
    {
        if(Auth::user()->role =='101'){
            $users = User::where('employee_id','!=','1011')->get();
            return view('users::index', compact('users'));
        }else{
            dd('You are not authorized for this section. Please contact the system admin.');
        }
        
    }

    public function showRegisterForm()
    {
        
        return view('auth.register');
    }

    public function register(Request $request)
    {
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', 
            'role' => 'required|string|max:50',
        ]);
        

        if($data['role']=="admin"){
            $role= '101';
        }else{
            $role= '505';
        }
        $lastIndex = User::latest('id')->value('id') ?? 0;
        DB::transaction(function () use ($role, $lastIndex,$data) {
            $user = User::create([
                'employee_id' => $role . ($lastIndex + 1),
                'name' => $data['name'],
                'email' => $data['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($data['password']),
                'role' => $role,
                'created_at' => now(),
            ]);

            if ($role === '505') {
                $leave = Settings::where('key', 'leave_policy')->first()->value;
                 LeaveBalance::create([
                    'employee_id' => $role . ($lastIndex + 1),
                    'year' => now()->year,
                    'paid_total' => $leave['paid_leave'],
                    'paid_used' => 0,
                    'unpaid_total' => $leave['unpaid_leave'],
                    'unpaid_used' => 0,
                    'created_at' => now(),
                ]);
            }

            
        });
        

        return redirect('/users')->with('success', 'User registered successfully!');
    }
    
}
