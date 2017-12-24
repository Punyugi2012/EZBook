<?php

namespace App\Http\Controllers\web\publisher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Purchase;
use App\BookType;
use App\Book;

class PublisherController extends Controller
{
    public function onLogin() {
        $bookTypes = BookType::get();
        return view('web.publisher.login', ['bookTypes'=>$bookTypes]);
    }
    public function checkLogin(Request $request) {
        $user = User::where('username', $request->input('username'))
            ->where('password', $request->input('password'))
            ->where('type', 'publisher')->first();
        if($user && $user->publisher->status == 'able') {
            session()->put('publisher', $user);
            session()->flash('publisher-login', 'เข้าสู่ระบบสำเร็จ');
            return redirect('/publisher-dashboard');
        }
        session()->flash('publisher-login', 'เข้าสู่ระบบไม่สำเร็จ กรุณาตรวจสอบ username, password');
        return redirect('/publisher-login');
    }
    public function onLogout() {
        session()->forget('publisher');
        session()->flash('publisher-logout', 'ออกจากระบบสำเร็จ');
        return redirect('publisher-login');
    }
    public function onDashboard() {
        $purchases = Purchase::get();
        $total = 0.0;
        foreach($purchases as $purchase) {
            if($purchase->book->publisher_id == session()->get('publisher')->publisher->id) {
                $total += $purchase->price;
            }
        }
        $max = Book::where('publisher_id', session()->get('publisher')->publisher->id)->max('num_read');
        $topBooks = Book::where('publisher_id', session()->get('publisher')->publisher->id)
                ->where('num_read', $max)->get();
        $maxScore = Book::where('publisher_id', session()->get('publisher')->publisher->id)->max('score');
        $maxScoreBooks = Book::where('publisher_id', session()->get('publisher')->publisher->id)
                ->where('score', $maxScore)->get();
        return view('web.publisher.publisherDashboard', [
            'isDashboard'=>true,
            'isBooks'=>false,
            'isProfile'=>false,
            'isHistory'=>false,
            'total'=>$total,
            'topBooks'=>$topBooks,
            'maxScoreBooks'=>$maxScoreBooks
        ]);
    }
    public function onBooks() {
        $bookTypes = BookType::get();
        foreach($bookTypes as $type) {
            foreach($type->books as $book) {
                $type->books = $type->books()->where('publisher_id', session()->get('publisher')->publisher->id)->get();
            }
        }
        $numOfBook = Book::where('publisher_id', session()->get('publisher')->publisher->id)->count('id');
        return view('web.publisher.publisherDashboard', [
            'isDashboard'=>false,
            'isBooks'=>true,
            'isProfile'=>false,
            'isHistory'=>false,
            'numOfBook'=>$numOfBook,
            'bookTypes'=>$bookTypes,
            'isSearch'=>false
        ]);
    }
    public function onProfile() {
        return view('web.publisher.publisherDashboard', [
            'isDashboard'=>false,
            'isBooks'=>false,
            'isProfile'=>true,
            'isHistory'=>false,
        ]);
    }
    public function onHistory() {
        $purchases = Purchase::get();
        $filterPurchases = [];
        foreach($purchases as $purchase) {
            if($purchase->book->publisher_id == session()->get('publisher')->publisher->id) {
                array_push($filterPurchases, $purchase);
            }
        }
        $purchases = $filterPurchases;
        return view('web.publisher.publisherDashboard', [
            'isDashboard'=>false,
            'isBooks'=>false,
            'isProfile'=>false,
            'isHistory'=>true,
            'purchases'=>$purchases
        ]);
    }
    public function searchBook(Request $request) {
        $bookTypes = BookType::get();
        $numOfBook = 0;
        foreach($bookTypes as $type) {
            $filterBooks = [];
            foreach($type->books as $book) {
                if($book->name == $request->input('search')) {
                    array_push($filterBooks, $book);
                    $numOfBook++;
                }
            }
            $type->books = $filterBooks;
        }
        return view('web.publisher.publisherDashboard', [
            'isDashboard'=>false,
            'isBooks'=>true,
            'isProfile'=>false,
            'isHistory'=>false,
            'bookTypes'=>$bookTypes,
            'numOfBook'=>$numOfBook,
            'isSearch'=>true,
            'search'=>$request->input('search')
        ]);
    }
    public function book($bookId) {
        $book = Book::find($bookId);
        return view('web.publisher.book', ['book'=>$book]);
    }
}
