<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    public function index(){
        return view('dashboard.profile.index');
    }


    public function name_update(Request $request){
        $oldname = Auth::user()->name;
        $request->validate([
             'name' => 'required|alpha',
        ]);

        User::find(auth()->user()->id)->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return back()->with('name_update',"name update successful $oldname to $request->name");
    }

    public function email_update(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        User::find(auth()->user()->id)->update([
            'email' => $request->email,
            'updated_at' => now(),
        ]);

        return back()->with('email_update', "email update successful");
    }

    public function password_update(Request $request){
        $request->validate([
            'current_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed',

        ]);

        if(Hash::check($request->current_password,Auth::user()->password)){
            User::find(auth()->user()->id)->update([
                'password' => $request->password,
                'updated_at' => now(),
            ]);

            return back()->with('password_update',"password update successful ");
        }else{

            return back()->withErrors(['current_password' => "Failed"])->withInput();
        }

    }

    public function image_update(Request $request){

        $manager = new ImageManager(new Driver());

        if($request->hasFile('image')){
             $newname = Auth::user()->id .'-'. now()->format('M d ,Y') .'-'. rand(0,9999) .'.'. $request->file('image')->getClientOriginalExtension();
            $image = $manager->read($request->file('image'));
            $image->toPng()->save(base_path('public/uploads/profile/'.$newname));
            User::find(auth()->user()->id)->update([
                'image' => $newname,
                'updated_at' => now(),
            ]);
            return back()->with('image_update',"image update successful ");
        }




    }





}
