<?php

namespace App\Http\Controllers\web\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Book;
use App\BookType;
use App\Member;
use App\User;
use Carbon\Carbon;
use App\Publisher;


class UserController extends Controller
{
    public function index() {
        $bookTypes = BookType::get();
        $publishers = $this->getPublisherLimit();
        $now = Carbon::now();
        $monthCurrent = $now->format('m');
        $books = Book::get();
        $filterBooks = [];
        for($i = 0; $i < count($books) && $i < 8; $i++) {
            if($monthCurrent - $books[$i]->created_at->month <= 1) {
                array_push($filterBooks, $books[$i]);
            }
        }
        $books = $filterBooks;
        return view('web.user.home', [
            'isNewBook'=>true,
            'isRecommend'=>false,
            'isFree'=>false,
            'isDiscount'=>false,
            'bookTypes'=>$bookTypes,
            'books'=>$books,
            'publishers'=>$publishers
        ]);
    } 
    private function getPublisherLimit() {
        return Publisher::paginate(8);
    }  
    public function onRecommend() {
        $bookTypes = BookType::get();
        $publishers = $this->getPublisherLimit();
        return view('web.user.home', [
            'isNewBook'=>false,
            'isRecommend'=>true,
            'isFree'=>false,
            'isDiscount'=>false,
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers
        ]);
    }
    public function onDiscount() {
        $bookTypes = BookType::get();
        $books = Book::where('discount_percent', '>', '0')->where('price', '>', '0')->get();
        $publishers = $this->getPublisherLimit();
        return view('web.user.home', [
            'isNewBook'=>false,
            'isRecommend'=>false,
            'isDiscount'=>true,
            'isFree'=>false,
            'books'=>$books,
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers
        ]);
    }
    public function onFree() {
        $bookTypes = BookType::get();
        $books = Book::where('price', 0)->get();
        $publishers = $this->getPublisherLimit();
        return view('web.user.home', [
            'isNewBook'=>false,
            'isRecommend'=>false,
            'isDiscount'=>false,
            'isFree'=>true,
            'books'=>$books,
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers
        ]);
    }
    public function onLogin() {
        $bookTypes = BookType::get();
        return view('web.user.userLogin', ['bookTypes'=>$bookTypes]);
    }
    public function checkLogin(Request $request) {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('username', $request->input('username'))->where('password', $request->input('password'))->where('type', 'user')->first();
        if($user) {
            session()->put('user', $user);
            return redirect('/');
        }
        else {
            return redirect('/user-login');
        }
    }
    public function logout() {
         session()->forget('user');
        return back();
    }
    public function onRegister(Request $request) {
        $bookTypes = BookType::get();
        return view('web.user.register', ['bookTypes'=>$bookTypes]);
    }
    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'address' => 'required',
            'phone' => 'required|regex:/(0)[0-9]{9}/',
            'gender' => 'required',
            'birthday' => 'required',
            'username'=>'required|unique:users',
            'email'=>'required|unique:users',
            'password'=>'required'
        ]);
        $image = md5(uniqid(rand(), true)).'.'.$request->file('image')->getClientOriginalName();
        $urlImage = $request->file('image')->storeAs('public/file/user-image', $image);
        User::create([
            'username'=>$request->input('name'),
            'password'=>$request->input('password'),
            'email'=>$request->input('email'),
            'type'=>'user'
        ]);
        Member::create([
            'name'=>$request->input('name'),
            'surname'=>$request->input('surname'),
            'phone'=>$request->input('phone'),
            'address'=>$request->input('address'),
            'gender'=>$request->input('gender'),
            'birthday'=>$request->input('birthday'),
            'status'=>'able',
            'image'=>$urlImage,
            'url_image'=>Storage::url($urlImage),
            'user_id'=>User::latest('id')->first()->id
        ]);
        return redirect('/user-login');
    }

}
