<?php

namespace App\Http\Controllers\web\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPassword;
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
use App\Account;

class UserController extends Controller
{
    private function getTopBooks() {
        $books = Book::get();
        $maxOne = 0;
        $bookOne = null;
        foreach($books as $book) {
            $num = Purchase::where('book_id', $book->id)->count('id');
            if($num > $maxOne) {
                $maxOne = $num;
                $bookOne = $book;
            }
        }
        $maxTwo = 0;
        $bookTwo = null;
        foreach($books as $book) {
            if($book->id != $bookOne->id) {
                $num = Purchase::where('book_id', $book->id)->count('id');
                if($num > $maxTwo) {
                    $maxTwo = $num;
                    $bookTwo = $book;
                }
            }   
        }
        $maxThree = 0;
        $bookThree = null;
        foreach($books as $book) {
            if($book->id != $bookOne->id && $book->id != $bookTwo) {
                $num = Purchase::where('book_id', $book->id)->count('id');
                if($num > $maxThree) {
                    $maxThree = $num;
                    $bookThree = $book;
                }
            }
        }
        $maxFour= 0;
        $bookFour = null;
        foreach($books as $book) {
            if($book->id != $bookOne->id && $book->id != $bookTwo && $book->id != $bookThree->id) {
                $num = Purchase::where('book_id', $book->id)->count('id');
                if($num > $maxFour) {
                    $maxFour = $num;
                    $bookFour = $book;
                }
            }
        }
        $maxFive= 0;
        $bookFive = null;
        foreach($books as $book) {
            if($book->id != $bookOne->id && $book->id != $bookTwo && $book->id != $bookThree->id && $book->id != $bookFour->id) {
                $num = Purchase::where('book_id', $book->id)->count('id');
                if($num > $maxFive) {
                    $maxFive = $num;
                    $bookFive = $book;
                }
            }
        }
        return [
                'bookOne'=>$bookOne, 
                'bookTwo'=>$bookTwo, 
                'bookThree'=>$bookThree, 
                'bookFour'=>$bookFour, 
                'bookFive'=>$bookFive
            ];
    }
    public function index() {
        $bookTypes = BookType::get();
        $publishers = $this->getPublisherLimit();
        $books = Book::orderBy('id', 'desc')->paginate(8);
        $infos = $this->getInfosLimit();
        $topBooks = $this->getTopBooks();
        return view('web.user.home', [
            'isNewBook'=>true,
            'isRecommend'=>false,
            'isFree'=>false,
            'isDiscount'=>false,
            'bookTypes'=>$bookTypes,
            'books'=>$books,
            'publishers'=>$publishers,
            'infos'=>$infos,
            'topBooks'=>$topBooks
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
        $books = Book::where('recommend', 'yes')->paginate(8);
        $topBooks = $this->getTopBooks();
        return view('web.user.home', [
            'isNewBook'=>false,
            'isRecommend'=>true,
            'isFree'=>false,
            'isDiscount'=>false,
            'books'=>$books,
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers,
            'infos'=>$infos,
            'topBooks'=>$topBooks
        ]);
    }
    public function onDiscount() {
        $bookTypes = BookType::get();
        $books = Book::where('discount_percent', '>', '0')->where('price', '>', '0')->get();
        $publishers = $this->getPublisherLimit();
        $infos = $this->getInfosLimit();
        $topBooks = $this->getTopBooks();
        return view('web.user.home', [
            'isNewBook'=>false,
            'isRecommend'=>false,
            'isDiscount'=>true,
            'isFree'=>false,
            'books'=>$books,
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers,
            'infos'=>$infos,
            'topBooks'=>$topBooks
        ]);
    }
    public function onFree() {
        $bookTypes = BookType::get();
        $books = Book::where('price', 0)->get();
        $publishers = $this->getPublisherLimit();
        $infos = $this->getInfosLimit();
        $topBooks = $this->getTopBooks();
        return view('web.user.home', [
            'isNewBook'=>false,
            'isRecommend'=>false,
            'isDiscount'=>false,
            'isFree'=>true,
            'books'=>$books,
            'bookTypes'=>$bookTypes,
            'publishers'=>$publishers,
            'infos'=>$infos,
            'topBooks'=>$topBooks
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
        $user = User::where('username', $request->input('username'))
        ->where('password', $request->input('password'))
        ->where('type', 'user')
        ->first();
        if($user && $user->member->status == 'able') {
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
            'id_card'=>'required|min:13|max:13|unique:members',
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
            'id_card'=>$request->input('id_card'),
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
            'id_card'=>'required|min:13|max:13',
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
            'id_card'=>$request->input('id_card'),
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
    public function onRecommendBooks() {
        $bookTypes = BookType::get();
        $books = Book::where('recommend', 'yes')->paginate(12);
        return view('web.user.recommendBooks', [
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
    private function calculateBookScore($book) {
        $numVoted = Vote::where('book_id', $book->id)->count('id');
        $sum = Vote::where('book_id', $book->id)->sum('score');
        $book->score = $numVoted == 0 ? 0 : $sum / $numVoted;
        $book->save();
    }
    public function book($bookId) {
        $bookTypes = BookType::get();
        $book = Book::find($bookId);
        $this->calculateBookScore($book);
        $isBought = false;
        $isVoted = false;
        $scoreVoted = null;
        if(session()->has('user')) {
            $result = Purchase::where('member_id', session()->get('user')->member->id)->where('book_id', $bookId)->first();
            if($result) {
                $isBought = true;
            }
            $result = Vote::where('member_id', session()->get('user')->member->id)->where('book_id', $bookId)->first();

            if($result) {
                $isVoted = true;
                $scoreVoted = $result->score;
            }
        }
        return view('web.user.book', [
            'bookTypes'=>$bookTypes,
            'book'=>$book,
            'isBought'=>$isBought,
            'isVoted'=>$isVoted,
            'scoreVoted'=>$scoreVoted
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
    public function vote(Request $request, $bookId) {
        $validatedData = $request->validate([
            'vote'=>'required'
        ]);
        Vote::create([
            'score'=>$request->input('vote'),
            'member_id'=>session()->get('user')->member->id,
            'book_id'=>$bookId
        ]);
        return back();
    }
    public function editVote(Request $request, $bookId) {
        $validatedData = $request->validate([
            'edit_vote'=>'required'
        ]);
        Vote::where('member_id', session()->get('user')->member->id)->where('book_id', $bookId)->first()->update([
            'score'=>$request->input('edit_vote')
        ]);
        return back();
    }
    public function onForgetPassword() {
        $bookTypes = BookType::get();
        return view('web.user.forgetPassword', [
            'bookTypes'=>$bookTypes
        ]);
    }
    public function sendEmail(Request $request) {
        $validatedData = $request->validate([
            'username'=>'required',
            'email'=>'required'
        ]);
        $email = $request->input('email');
        $user =  User::where('email', $email)
        ->where('username', $request->input('username'))
        ->where('type', 'user')
        ->first();
        if($user && $user->member->status == 'able') {
            Mail::to($email)->send(new SendPassword($user));
            return redirect('/send-password-success');
        }
        else {
            return back();
        }
    }
    public function sendSuccess() {
        $bookTypes = BookType::get();
        return view('web.user.sendPassword', [
            'bookTypes'=>$bookTypes
        ]);
    }
    public function buyBook($bookId) {
        $book = Book::find($bookId);
        Purchase::create([
            'date_purchase'=>Carbon::now(),
            'price'=>$book->price,
            'member_id'=>session()->get('user')->member->id,
            'book_id'=>$bookId
        ]);
        return redirect('/book/'.$bookId);
        // $bookTypes = BookType::get();
        // return view('web.user.sendPassword', [
        //     'bookTypes'=>$bookTypes
        // ]);
    }
    public function bind(Request $request) {
        $validatedData = $request->validate([
            'account_number'=>'required|min:10|max:12|unique:accounts',
            'expired_date'=>'required',
            'cvv'=>'required|min:3|max:4'
        ]);
        Account::create([
            'account_number'=>$request->input('account_number'),
            'expired_date'=>$request->input('expired_date'),
            'cvv'=>$request->input('cvv'),
            'member_id'=>session()->get('user')->member->id
        ]);
        session()->get('user')->member->account = Account::latest('id')->first();
        return redirect('/user-profile');
    }
    public function editBind(Request $request, $bindId) {
        $validatedData = $request->validate([
            'edit_account_number'=>'required|min:10|max:12',
            'edit_expired_date'=>'required',
            'edit_cvv'=>'required|min:3|max:4'
        ]);
        Account::find($bindId)->update([
            'account_number'=>$request->input('edit_account_number'),
            'expired_date'=>$request->input('edit_expired_date'),
            'cvv'=>$request->input('edit_cvv'),
        ]);
        session()->get('user')->member->account = Account::find($bindId);
        return redirect('/user-profile');
    }
}
