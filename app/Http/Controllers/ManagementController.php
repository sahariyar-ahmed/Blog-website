<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementController extends Controller
{
    public function index(){
        $managers = User::where('role','manager')->get();
        return view('dashboard.management.auth.register',compact('managers'));
    }

    public function store_register(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8' ],
            'role' => 'required|in:manager,blogger,user',
        ]);

        if(!$request->role == ""){
            User::create([
                'name' => $request->name,
                'email'=> $request->email,
                'password'=> $request->password,
                'role'=> $request->role,
            ]);
            return back()->with('register_complete' , "Registration complete");
        }else{
            return back()->withErrors(['role' => "please , Select role first"])->withInput();
        }


    }

    public function manager_down($id){
        $manager = User::where('id',$id)->first();

        if ($manager->role == 'manager') {
            User::find($manager->id)->update([
                'role' => 'user',
                'updated_at' => now(),
            ]);
            return back()->with('register_complete' , "Manager Demotion successfull");

        }


    }


    //role manage
    public function role_index(){
        $bloggers = User::where('role','blogger')->get();
        $users = User::where('role','user')->where('block',false)->get();
        return view('dashboard.management.role.index',[
            'dedsec' => $users,
            'red' => $bloggers,
        ]);
    }

    public function role_assign(Request $request){

        $request->validate([
            'role' => 'required|in:manager,blogger,user',
        ]);

        $user = User::where('id',$request->user_id)->first();

        User::find($user->id)->update([
            'role'=> $request->role,
            'updated_at'=> now(),
        ]);

        Session::flash('assignrole','Role Assign Successful');
        return back();
    }


    public function blogger_grade_down($id){
        $user = User::where('id',$id)->first();
        if ($user->role == 'blogger') {
            User::find($user->id)->update([
                'role'=> 'user',
                'updated_at'=> now(),
            ]);
            Session::flash('assignrole','Role Downgrading Successful');
            return back();
        }
    }  
    
    public function user_grade_down($id){
        $user = User::where('id',$id)->first();
        if ($user->role == 'user') {
            User::find($user->id)->update([
                'block'=> true,
                'updated_at'=> now(),
            ]);
            Session::flash('assignrole','User blocked ');
            return back();
        }
    }
    


}
