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
use App\Purchase;


class UserController extends Controller
{
    public function index() {
        $bookTypes = BookType::get();
        $publishers = $this->getPublisherLimit();
        $now = Carbon::now();
        $monthCurrent = $now->format('m');
        $books = Book::orderBy('id', 'desc')->paginate(8);
        $filterBooks = [];
        $round = 0;
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
        $publishers = Publisher::orderBy('id', 'desc')->paginate(8);
        return $publishers;
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
        $urlImage = null;
        if($request->hasFile('image')) {
            $image = md5(uniqid(rand(), true)).'.'.$request->file('image')->getClientOriginalName();
            $urlImage = $request->file('image')->storeAs('public/file/user-image', $image);
        }
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
    public function onProfile(Request $request) {
        $bookTypes = BookType::get();
        $publishers = $this->getPublisherLimit();
        $purchases = Purchase::where('member_id', session()->get('user')->member->id)->orderBy('id', 'desc')->paginate(10);
        foreach($purchases as $purchase) {
            $purchase->book = Book::find($purchase->book_id);
        }
        $hasQuery = false;
        if($request->query()) {
            $hasQuery = true;
        }
        return view('web.user.profile', [
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers,
            'purchases'=>$purchases,
            'hasQuery'=>$hasQuery
        ]);
    }
    public function update(Request $request, $userId) {
        $validatedData = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'address' => 'required',
            'phone' => 'required|regex:/(0)[0-9]{9}/',
            'gender' => 'required',
            'birthday' => 'required',
        ]);
        $urlImage = null;
        if($request->hasFile('image')) {
            $image = md5(uniqid(rand(), true)).'.'.$request->file('image')->getClientOriginalName();
            $urlImage = $request->file('image')->storeAs('public/file/user-image', $image);
        }
        Member::find($userId)->update([
            'name'=>$request->input('name'),
            'surname'=>$request->input('surname'),
            'phone'=>$request->input('phone'),
            'address'=>$request->input('address'),
            'gender'=>$request->input('gender'),
            'birthday'=>$request->input('birthday'),
            'image'=>$urlImage,
            'url_image'=>Storage::url($urlImage),
        ]);
        session()->get('user')->member = Member::find($userId);
        return redirect('user-profile');
    }
    public function books($typeId) {
        $bookTypes = BookType::get();
        $publishers = $this->getPublisherLimit();
        $books = Book::where('book_type_id', $typeId)->paginate(10);
        $type = BookType::find($typeId);
        return view('web.user.books', [
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers,
            'books'=>$books,
            'type'=>$type
        ]);
    }
    public function search(Request $request) {
        $bookTypes = BookType::get();
        $publishers = $this->getPublisherLimit();
        $allPublishers = Publisher::get();
        $found = 0;
        if($request->input('search-type')) {
            $books = Book::where('name', $request->input('search'))
            ->where('book_type_id', $request->input('search-type'))
            ->paginate(10);
            $found =  Book::where('name', $request->input('search'))->where('book_type_id', $request->input('search-type'))->count('id');
        }
        else {
            $books = Book::where('name', $request->input('search'))->paginate(10);
            $found = Book::where('name', $request->input('search'))->count('id');
        }
        return view('web.user.search-books', [
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers,
            'books'=>$books,
            'found'=>$found,
            'search'=>$request->input('search'),
            'allPublishers'=>$allPublishers
        ]);
    }

}
