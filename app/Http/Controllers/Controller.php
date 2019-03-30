<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    public function Do_login()
    {
    	$username = Input::post('username');
    	$password = Input::post('password');
		if (Auth::attempt(['username' => $username, 'password' => $password])) {
                $users_data = DB::table('users')->select('*')->where('username', $username)->get();
                $arrayData = array(
                	'name' => $users_data[0]->name,
                	'email'=> $users_data[0]->email,
                	'username'=> $users_data[0]->username,
                	'created_at'=> $users_data[0]->created_at,
                    'updated_at' => $users_data[0]->updated_at,
                    'access_rights_member'=> $users_data[0]->access_rights_member,
                    'access_rights_setting'=> $users_data[0]->access_rights_setting);
				Session::put('Login', $arrayData);
                date_default_timezone_set("Asia/Bangkok");
                $today = now();
                DB::table('users')
                ->where('username', $username)
                ->update(['updated_at'  => $today]);
		        return redirect('Dashboard');
		}
		elseif (Auth::attempt(['email'=> $username, 'password' => $password])) {
				$users_data = DB::table('users')->select('*')->where('username', $username)->get();
                $arrayData = array(
                	'name' => $users_data[0]->name,
                	'email'=> $users_data[0]->email,
                	'username'=> $users_data[0]->username,
                	'created_at'=> $users_data[0]->created_at,
                    'updated_at' => $users_data[0]->updated_at,
                    'access_rights_member'=> $users_data[0]->access_rights_member,
                    'access_rights_setting'=> $users_data[0]->access_rights_setting);
				Session::put('Login', $arrayData);
                date_default_timezone_set("Asia/Bangkok");
                $today = now();
                DB::table('users')
                ->where('username', $username)
                ->update(['updated_at'  => $today]);
		        return redirect('Dashboard');
		}
		else {
				return back()->withInput();
		}
    }

    public function Logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function Create_user_dev($user,$password,$name,$email,$status,$token)
    {
        $today = now();
        $remakepassword = Hash::make($password);
        // Insert User
        DB::table('users')->insert([
        "name" => "$name",
        "email" => "$email",
        "username" => "$user",
        "password" => "$remakepassword",
        "status" => "$status",
        "remember_token" => "$token",
        "created_at" => "$today",
        "updated_at" => "$today"
        ]);
    }

}
