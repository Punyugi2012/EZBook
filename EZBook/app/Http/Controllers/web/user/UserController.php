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
use App\Comment;
use App\Vote;
use App\Info;
use App\Author;


class UserController extends Controller
{
    public function index() {
        $bookTypes = BookType::get();
        $publishers = $this->getPublisherLimit();
        $books = Book::orderBy('id', 'desc')->paginate(8);
        $infos = $this->getInfosLimit();
        return view('web.user.home', [
            'isNewBook'=>true,
            'isRecommend'=>false,
            'isFree'=>false,
            'isDiscount'=>false,
            'bookTypes'=>$bookTypes,
            'books'=>$books,
            'publishers'=>$publishers,
            'infos'=>$infos
        ]);
    } 
    private function getPublisherLimit() {
        $publishers = Publisher::orderBy('id', 'desc')->paginate(8);
        return $publishers;
    }  
    private function getInfosLimit() {
        return Info::orderBy('id', 'desc')->paginate(8);
    }
    public function onRecommend() {
        $bookTypes = BookType::get();
        $publishers = $this->getPublisherLimit();
        $infos = $this->getInfosLimit();
        return view('web.user.home', [
            'isNewBook'=>false,
            'isRecommend'=>true,
            'isFree'=>false,
            'isDiscount'=>false,
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers,
            'infos'=>$infos
        ]);
    }
    public function onDiscount() {
        $bookTypes = BookType::get();
        $books = Book::where('discount_percent', '>', '0')->where('price', '>', '0')->get();
        $publishers = $this->getPublisherLimit();
        $infos = $this->getInfosLimit();
        return view('web.user.home', [
            'isNewBook'=>false,
            'isRecommend'=>false,
            'isDiscount'=>true,
            'isFree'=>false,
            'books'=>$books,
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers,
            'infos'=>$infos
        ]);
    }
    public function onFree() {
        $bookTypes = BookType::get();
        $books = Book::where('price', 0)->get();
        $publishers = $this->getPublisherLimit();
        $infos = $this->getInfosLimit();
        return view('web.user.home', [
            'isNewBook'=>false,
            'isRecommend'=>false,
            'isDiscount'=>false,
            'isFree'=>true,
            'books'=>$books,
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers,
            'infos'=>$infos
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
            'username'=>$request->input('username'),
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
        $secondPurchases = Purchase::where('member_id', session()->get('user')->member->id)->orderBy('id', 'desc')->paginate(10);
        return view('web.user.profile', [
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers,
            'purchases'=>$purchases,
            'hasQuery'=>$hasQuery,
            'secondPurchases'=>$secondPurchases
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
            'books'=>$books,
            'found'=>$found,
            'search'=>$request->input('search'),
        ]);
    }
    public function onNewBooks() {
        $bookTypes = BookType::get();
        $books = Book::orderBy('id', 'desc')->paginate(12);
        return view('web.user.newBooks', [
            'bookTypes'=>$bookTypes,
            'books'=>$books
        ]);
    }
    public function onFreeBooks() {
        $bookTypes = BookType::get();
        $books = Book::where('price', 0)->paginate(12);
        return view('web.user.freeBooks', [
            'bookTypes'=>$bookTypes,
            'books'=>$books
        ]);
    }
    public function onDiscountBooks() {
        $bookTypes = BookType::get();
        $books = Book::where('discount_percent', '>', '0')->paginate(12);
        return view('web.user.discountBooks', [
            'bookTypes'=>$bookTypes,
            'books'=>$books
        ]);
    }
    public function onPublishers() {
        $bookTypes = BookType::get();
        $publishers = Publisher::orderBy('id', 'desc')->paginate(12);
        return view('web.user.publishers', [
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers
        ]);
    }
    public function book($bookId) {
        $bookTypes = BookType::get();
        $book = Book::find($bookId);
        $isBought = false;
        $isVoted = false;
        if(session()->has('user')) {
            $result = Purchase::where('member_id', session()->get('user')->member->id)->where('book_id', $bookId)->first();
            if($result) {
                $isBought = true;
            }
            $result = Vote::where('member_id', session()->get('user')->member->id)->where('book_id', $bookId)->first();
            if($result) {
                $isVoted = true;
            }
        }
        return view('web.user.book', [
            'bookTypes'=>$bookTypes,
            'book'=>$book,
            'isBought'=>$isBought,
            'isVoted'=>$isVoted
        ]);
    }
    public function comment(Request $request, $bookId) {
        $validatedData = $request->validate([
            'comment' => 'required',
        ]);
        Comment::create([
            'message'=>$request->input('comment'),
            'book_id'=>$bookId,
            'member_id'=>session()->get('user')->member->id
        ]);
        return redirect('/book/'.$bookId);
    }
    public function publisherBooks($publisherId, $type="all") {
        $publisher = Publisher::find($publisherId);
        $books = $publisher->books;
        if($type == 'all') {
            $type = 'ทั้งหมด';
        }
        else {
            $filterBook = [];
            foreach($books as $book) {
                if($book->book_type_id == $type) {
                    array_push($filterBook, $book);
                }
            }
            $type = BookType::find($type)->name;
            $books = $filterBook;
        }
        $bookTypes = BookType::get();
        return view('web.user.publisherBooks',[
            'books'=>$books,
            'publisher'=>$publisher,
            'bookTypes'=>$bookTypes,
            'type'=>$type
        ]);
    }
    public function authorBooks($authorId, $type="all") {
        $author = Author::find($authorId);
        $books = $author->books;
        if($type == 'all') {
            $type = 'ทั้งหมด';
        }
        else {
            $filterBook = [];
            foreach($books as $book) {
                if($book->book_type_id == $type) {
                    array_push($filterBook, $book);
                }
            }
            $type = BookType::find($type)->name;
            $books = $filterBook;
        }
        $bookTypes = BookType::get();
        return view('web.user.authorBooks',[
            'books'=>$books,
            'author'=>$author,
            'bookTypes'=>$bookTypes,
            'type'=>$type
        ]);
    }
    public function userBooks() {
        $bookTypes = BookType::get();
        $purchases = Purchase::where('member_id', session()->get('user')->member->id)->orderBy('id', 'desc')->paginate(8);
        return view('web.user.userBooks',[
            'purchases'=>$purchases,
            'bookTypes'=>$bookTypes
        ]);
    }
    public function onInfos() {
        $infos = Info::paginate(8);
        $bookTypes = BookType::get();
        return view('web.user.infos', [
            'bookTypes'=>$bookTypes,
            'infos'=>$infos
        ]);
    }
    public function info($infoId) {
        $info = Info::find($infoId);
        $bookTypes = BookType::get();
        return view('web.user.info', [
            'bookTypes'=>$bookTypes,
            'info'=>$info
        ]);
    }
}
