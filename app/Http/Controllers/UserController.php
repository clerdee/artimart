<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;


class UserController extends Controller
{
    

    
    public function update_role(Request $request, $id)
    {
        // dd($request->role, $id);
        User::where('id', $id)
            ->update(['role' => $request->role]);
            return redirect()->back()->with('success', 'Role updated successfully.');
    }

    public function update_status(Request $request, $id)
    {
        // dd($request->status, $id);
        $request->validate([
            'status' => 'required|in:Active,Deactivated',
        ]);
    
        User::where('id', $id)->update(['status' => $request->status]);
    
        return redirect()->back()->with('success', 'Status updated successfully.');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function show()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $layout = $user->role === 'Admin' ? 'layouts.admin-header' : 'layouts.header';
    
        $customer = DB::table('customer')->where('user_id', $user->id)->first();

          
        return view('users.edit', compact('user', 'customer', 'layout'));
    }
    
    
    public function updateProfile(Request $request)
    {

        $user = User::find(Auth::id());
        $customer = Customer::where('user_id', $user->id)->firstOrFail();

    
        $request->validate([
            'title' => 'required', 'string', 'max:10',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Concatenate first name and last name for User
        $fullName = trim($request->fname) . ' ' . trim($request->lname);
    
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('public/images');
            $user->profile_image = str_replace('public/', '', $path);
        }
    
        // Update User model
        $user->name = $fullName;
        $user->save();
    
        // Update Customer model
        $customer->update([
            'title' => trim($request->title),
            'fname' => trim($request->fname),
            'lname' => trim($request->lname),
            'addressline' => trim($request->address),
            'town' => trim($request->town),
            'phone' => trim($request->phone)
        ]);
    
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updateSecurity(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'current_password' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }
    
        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        return redirect()->back()->with('success', 'Security settings updated successfully.');
    }

    
}
