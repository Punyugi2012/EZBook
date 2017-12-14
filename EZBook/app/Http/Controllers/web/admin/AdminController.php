<?php

namespace App\Http\Controllers\web\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Publisher;
use App\BookType;
use App\Book;
use App\BookImage;

class AdminController extends Controller
{
    public function onLogin() {
        return view('web.admin.adminLogin');
    }
    public function checkLogin(Request $request) {
        $user = User::where('username', $request->input('username'))->where('password', $request->input('password'))->first();
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
    private function getPublishers() {
        $publishers = Publisher::get();
        foreach($publishers as $publisher) {
            $user = User::find($publisher->user_id);
            $publisher->username = $user->username;
            $publisher->email = $user->email;
            $publisher->password = $user->password;
        }
        return $publishers;
    }
    public function onPublishers() {
        $publishers = $this->getPublishers();
        return view('web.admin.adminDashboard', ['isPublishers'=>true, 'isUploadBooks'=>false, 'isMembers'=>false, 'publishers'=>$publishers]);
    }
    public function onUploadBooks() {
        $publishers = $this->getPublishers();
        $bookTypes = BookType::get();
        return view('web.admin.adminDashboard', ['isPublishers'=>false, 'isUploadBooks'=>true, 'isMembers'=>false, 'publishers'=>$publishers, 'bookTypes'=>$bookTypes]);
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
    public function uploadBook(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'file_size' => 'required',
            'num_page' => 'required',
            'publish' => 'required',
            'cover_image' => 'required',
            'images' => 'required',
            'file' => 'required'
        ]);

        $book = new Book();
        $book->name = $request->input('name');
        $book->file_size = $request->input('file_size');
        $book->num_page = $request->input('num_page');
        $book->price = $request->input('price');
        $book->detail = $request->input('detail');
        $book->date_publish = $request->input('publish');
        $book->book_type_id = $request->input('type');
        $book->publisher_id = $request->input('publisher');

        $fileNamePdf = md5(uniqid(rand(), true)).'.'.$request->file('file')->getClientOriginalName();
        $urlPdf = $request->file('file')->storeAs('public/file/book-pdf', $fileNamePdf);
        $book->path_file = $urlPdf;

        $fileNameCoverImage = md5(uniqid(rand(), true)).'.'.$request->file('cover_image')->getClientOriginalName();
        $urlCoverImage = $request->file('cover_image')->storeAs('public/file/cover-image', $fileNameCoverImage);
        $book->cover_image = $urlCoverImage;

        $book->save();
        
        foreach($request->file('images') as $image) {
            $fileNameImage = md5(uniqid(rand(), true)).'.'.$image->getClientOriginalName();
            $urlImage = $image->storeAs('public/file/book-image', $fileNameImage);
            BookImage::create(['pathFile'=>$urlImage, 'book_id'=>Book::latest('id')->first()->id]);
        }
        return redirect('/admin-uploadbooks');
    }
}
