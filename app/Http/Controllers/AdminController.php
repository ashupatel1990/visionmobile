<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Validator;

class AdminController extends Controller
{
    //View Loggedin user Profile
    public function profile()
    {  
        $admin = Auth::user();
        return view('admin.admin_profile_view', compact('admin'));
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'profile_image' => 'nullable',
        ]);

        $admin = User::find(Auth::user()->id);
        // dd($request->all());
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        if ($request->file('profile_image')) {
            $file = $request->file('profile_image');

            $filename = $admin->id.'-'.time().'-'.$file->getClientOriginalName();
            $file->move(public_path('admin/users/'), $filename);
            $admin->profile_image = $filename;
        }
        $admin->save();
        return redirect()->back()->with('message', 'Profile Updated Successfully');
    }

    public function changePassword() {
        $user = Auth::user();
        return view('auth.changepassword');
    }

    public function newPassword(Request $request) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'currentpassword' => 'required|min:8'
        ]);
        if (!Auth::attempt(['id'=>$user->id, 'password'=> $request->currentpassword]))
        {
            return redirect()->back()->withError(_('Current password is wrong!'));
        }
        if ($request->currentpassword == $request->password) {
            return redirect()->back()->withError(_('New password should not be same as current password!'));
        }
        if ($request->password != $request->password_confirmation) {
            return redirect()->back()->withError(_('Password and confirm password should be same!'));
        }

        User::where('id', $user->id)->update(['password' => Hash::make($request->password)]);
        Auth::logout();
        return Redirect::to('/login');
        // return redirect('dashboard')->withStatus(_('Password changed successfully!'));
    }
}
