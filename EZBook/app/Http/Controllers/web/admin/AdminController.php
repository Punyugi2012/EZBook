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
use App\Author;

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
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>false, 
            'isMembers'=>false,
            'isBooks'=>false,
            'isAuthors'=>false,
        ]);
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
        return view('web.admin.adminDashboard', [
            'isPublishers'=>true,
            'isUploadBooks'=>false,
            'isMembers'=>false,
            'isBooks'=>false,
            'isAuthors'=>false,
            'publishers'=>$publishers
        ]);
    }
    public function onUploadBooks() {
        $publishers = $this->getPublishers();
        $bookTypes = BookType::get();
        $authors = Author::get();
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>true, 
            'isMembers'=>false,
            'isBooks'=>false, 
            'isAuthors'=>false,
            'publishers'=>$publishers, 
            'bookTypes'=>$bookTypes,
            'authors'=>$authors
        ]);
    }
    public function onMembers() {
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>false, 
            'isMembers'=>true,
            'isBooks'=>false,
            'isAuthors'=>false,
        ]);
    }
    public function onBooks() {
        $bookTypes = BookType::get();
        $numOfBook = Book::count('id');
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>false, 
            'isMembers'=>false,
            'isBooks'=>true, 
            'isAuthors'=>false,
            'bookTypes'=>$bookTypes,
            'numOfBook'=>$numOfBook
        ]);
    }
    public function onAuthors() {
        $authors = Author::get();
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>false, 
            'isMembers'=>false,
            'isBooks'=>false,
            'isAuthors'=>true,
            'authors'=>$authors
        ]);
    }
    public function registerPublisher() {
        return view('web.admin.publisherRegister');
    }
    public function registerAuthor() {
        return view('web.admin.authorRegister');
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
       $validatedData = $request->validate([
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required|regex:/(0)[0-9]{9}/',
        'email' => 'required|unique:users'
       ]);
       $username = $this->generateRandomString();
       $password = $this->randomPassword();
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
           'status' => 'able',
           'user_id' => User::latest('id')->first()->id
       ]);
       return redirect('/admin-publishers');
    }
    public function onEditPublisher($publisherId) {
        $publisher = Publisher::find($publisherId);
        return view('web.admin.editPublisher', ['publisher'=>$publisher]);
    }
    public function updatePublisher(Request $request, $publisherId) {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|regex:/(0)[0-9]{9}/',
            'status' => 'required'
        ]);
        Publisher::find($publisherId)->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'status' => $request->input('status')
        ]);
        return redirect('admin-publishers');
    }
    public function createAuthor(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:authors',
            'phone' => 'required|regex:/(0)[0-9]{9}/'
        ]);
        Author::create([
            'name'=>$request->input('name'), 
            'email'=>$request->input('email'), 
            'phone'=>$request->input('phone')
        ]);
        return redirect('/admin-authors');
    }
    public function onEditAuthor($authorId) {
        $author = Author::find($authorId);
        return view('web.admin.editAuthor', ['author'=>$author]);
    }
    public function updateAuthor(Request $request, $authorId) {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|regex:/(0)[0-9]{9}/'
        ]);
        Author::find($authorId)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone')
        ]);
        return redirect('/admin-authors');
    }
    public function uploadBook(Request $request){
        $validatedData = $request->validate([
            'publisher'=>'required',
            'name' => 'required',
            'authors' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'file_size' => 'required',
            'num_page' => 'required',
            'publish' => 'required',
            'cover_image' => 'required',
            'file' => 'required',
            'status' => 'required'
        ]);

        $book = new Book();
        $book->name = $request->input('name');
        $book->file_size = $request->input('file_size');
        $book->num_page = $request->input('num_page');
        $book->price = $request->input('price');
        $book->discount_percent = $request->input('discount');
        $book->detail = $request->input('detail');
        $book->date_publish = $request->input('publish');
        $book->book_type_id = $request->input('type');
        $book->publisher_id = $request->input('publisher');

        $fileNamePdf = md5(uniqid(rand(), true)).'.'.$request->file('file')->getClientOriginalName();
        $urlPdf = $request->file('file')->storeAs('public/file/book-pdf', $fileNamePdf);
        $book->path_file = $urlPdf;
        $book->url_file = Storage::url($urlPdf);

        $fileNameCoverImage = md5(uniqid(rand(), true)).'.'.$request->file('cover_image')->getClientOriginalName();
        $urlCoverImage = $request->file('cover_image')->storeAs('public/file/cover-image', $fileNameCoverImage);
        $book->cover_image = $urlCoverImage;
        $book->url_cover_image = Storage::url($urlCoverImage);

        $book->save();
        if($request->hasFile('images')) {
            foreach($request->file('images') as $image) {
                $fileNameImage = md5(uniqid(rand(), true)).'.'.$image->getClientOriginalName();
                $urlImage = $image->storeAs('public/file/book-image', $fileNameImage);
                BookImage::create([
                    'pathFile'=>$urlImage, 
                    'url_image'=>Storage::url($urlImage), 
                    'book_id'=>Book::latest('id')->first()->id
                ]);
            }
        }
        $bookLatest = Book::latest('id')->first();
        foreach($request->input('authors') as $author) {
            $bookLatest->authors()->attach($author);
        }
        return redirect('/admin-books');
    }
    public function onBook($bookId) {
        $book = Book::find($bookId);
        return view('web.admin.bookProfile', ['book'=>$book]);
    }
    public function updateBook(Request $request, $bookId) {
        $validatedData = $request->validate([
            'status'=>'required',
            'price' => 'required',
            'discount' => 'required',
        ]);
        $book = Book::find($bookId);
        $book->status = $request->input('status');
        $book->price = $request->input('price');
        $book->detail = $request->input('detail');
        $book->discount_percent = $request->input('discount');
        $book->save();
        return redirect('/admin-book/'.$bookId);
    }
    public function onPublisherBooks($publisherId, $type='all') {
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
        return view('web.admin.publisherBooks', [
            'books'=>$books, 
            'publisher'=>$publisher,
            'bookTypes'=>$bookTypes,
            'type'=>$type
        ]);
    }
    public function onAuthorBooks($authorId, $type='all') {
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
        return view('web.admin.authorBooks', [
            'books'=>$books, 
            'author'=>$author,
            'bookTypes'=>$bookTypes,
            'type'=>$type
        ]);
    }
    public function searchPublisers(Request $request) {
        $publishers = $this->getPublishers();
        $filterPublishers = [];
        $search = $request->input('search');
        foreach($publishers as $publisher) {
            if(
                $publisher->name == $search || 
                $publisher->email == $search ||
                $publisher->phone == $search
            ) {
                array_push($filterPublishers, $publisher);
            }
        }
        $publishers = $filterPublishers;
        return view('web.admin.adminDashboard', [
            'isPublishers'=>true,
            'isUploadBooks'=>false,
            'isMembers'=>false,
            'isBooks'=>false,
            'isAuthors'=>false,
            'publishers'=>$publishers
        ]);
    }
    public function searchAuthors(Request $request) {
        $authors = Author::get();
        $filterAuthors = [];
        $search = $request->input('search');
        foreach($authors as $author) {
            if(
                $author->name == $search || 
                $author->email == $search ||
                $author->phone == $search
            ) {
                array_push($filterAuthors, $author);
            }
        }
        $authors = $filterAuthors;
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>false, 
            'isMembers'=>false,
            'isBooks'=>false,
            'isAuthors'=>true,
            'authors'=>$authors
        ]);

    }
    public function searchMembers(Request $request) {

    }
    public function searchBooks(Request $request) {
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
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>false, 
            'isMembers'=>false,
            'isBooks'=>true, 
            'isAuthors'=>false,
            'bookTypes'=>$bookTypes,
            'numOfBook'=>$numOfBook
        ]);
    }
}
