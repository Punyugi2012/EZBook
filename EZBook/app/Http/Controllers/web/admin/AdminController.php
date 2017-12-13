<?php

namespace App\Http\Controllers\web\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Publisher;

class AdminController extends Controller
{
    public function onLogin() {
        return view('web.admin.adminLogin');
    }
    public function checkLogin(Request $request) {
        $user = User::where('email', $request->input('email'))->where('password', $request->input('password'))->first();
        if($user) {
            session()->put('admin', $user);
            return redirect('/admin-dashboard');
        }
        return redirect('/admin-login');
    }
    public function onDashboard() {
        return view('web.admin.adminDashboard', ['isPublishers'=>false, 'isUploadBooks'=>false, 'isMembers'=>false]);
    }
    public function logout() {
        session()->forget('admin');
        return redirect('admin-login');
    }
    public function onPublishers() {
        $publishers = Publisher::get();
        foreach($publishers as $publisher) {
            $user = User::find($publisher->user_id);
            $publisher->username = $user->username;
            $publisher->email = $user->email;
            $publisher->password = $user->password;
        }
        return view('web.admin.adminDashboard', ['isPublishers'=>true, 'isUploadBooks'=>false, 'isMembers'=>false, 'publishers'=>$publishers]);
    }
    public function onUploadBooks() {
        return view('web.admin.adminDashboard', ['isPublishers'=>false, 'isUploadBooks'=>true, 'isMembers'=>false]);
    }
    public function onMembers() {
        return view('web.admin.adminDashboard', ['isPublishers'=>false, 'isUploadBooks'=>false, 'isMembers'=>true]);
    }
    public function registerPublisher() {
        return view('web.admin.publisherRegister');
    }
    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); 
        $alphaLength = strlen($alphabet) - 1; 
        for ($i = 0; $i < 5; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
    private function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function createPublisher(Request $request) {
       $username = $this->generateRandomString();
       $password = $this->randomPassword();
       $validatedData = $request->validate([
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'email' => 'required|unique:users'
       ]);
       User::create([
        'username' => $username,
        'password' => $password,
        'email' => $request->input('email'),
        'type' => 'publisher'
       ]);
       Publisher::create([
           'name' => $request->input('name'),
           'address' => $request->input('address'),
           'phone' => $request->input('phone'),
           'user_id' => User::latest('id')->first()->id
       ]);
       return redirect('/admin-publishers');
    }
}
