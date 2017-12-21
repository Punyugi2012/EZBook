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
use App\Info;
use App\Member;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function onLogin() {
        $bookTypes = BookType::get();
        return view('web.admin.adminLogin', ['bookTypes'=>$bookTypes]);
    }
    public function checkLogin(Request $request) {
        $user = User::where('username', $request->input('username'))->where('password', $request->input('password'))->where('type', 'admin')->first();
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
            'isNews'=>false
        ]);
    }
    public function logout() {
        session()->forget('admin');
        return redirect('admin-login');
    }
    public function onPublishers() {
        $publishers = Publisher::paginate(8);
        foreach($publishers as $publisher) {
            $publisher->email = $publisher->user->email;
            $publisher->username = $publisher->user->username;
            $publisher->password = $publisher->user->password;
        }
        return view('web.admin.adminDashboard', [
            'isPublishers'=>true,
            'isUploadBooks'=>false,
            'isMembers'=>false,
            'isBooks'=>false,
            'isAuthors'=>false,
            'isNews'=>false,
            'publishers'=>$publishers,
            'isSearch'=>false
        ]);
    }
    public function onUploadBooks() {
        $publishers = Publisher::get();
        $bookTypes = BookType::get();
        $authors = Author::get();
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>true, 
            'isMembers'=>false,
            'isBooks'=>false, 
            'isAuthors'=>false,
            'isNews'=>false,
            'publishers'=>$publishers, 
            'bookTypes'=>$bookTypes,
            'authors'=>$authors
        ]);
    }
    public function onMembers() {
        $members = Member::paginate(8);
        foreach($members as $member) {
            $member->email = $member->user->email;
            $member->age = Carbon::now()->year - Carbon::createFromFormat('Y-m-d', $member->birthday)->year;
        }
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>false, 
            'isMembers'=>true,
            'isBooks'=>false,
            'isAuthors'=>false,
            'isNews'=>false,
            'members'=>$members,
            'isSearch'=>false
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
            'isNews'=>false,
            'bookTypes'=>$bookTypes,
            'numOfBook'=>$numOfBook,
            'isSearch'=>false
        ]);
    }
    public function onAuthors() {
        $authors = Author::paginate(8);
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>false, 
            'isMembers'=>false,
            'isBooks'=>false,
            'isAuthors'=>true,
            'isNews'=>false,
            'authors'=>$authors,
            'isSearch'=>false
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
        $book->status = $request->input('status');
        $book->recommend = 'not';
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
            'recommend' => 'required'
        ]);
        $book = Book::find($bookId);
        $book->status = $request->input('status');
        $book->price = $request->input('price');
        $book->detail = $request->input('detail');
        $book->recommend = $request->input('recommend');
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
    public function searchPublisher(Request $request) {
       $validatedData = $request->validate([
        'search'=>'required'
       ]);
       $publishers = User::join('publishers', 'users.id', '=', 'publishers.user_id')
       ->where('name', $request->input('search'))
       ->orWhere('phone', $request->input('search'))
       ->orWhere('email', $request->input('search'))->paginate(8);
        return view('web.admin.adminDashboard', [
            'isPublishers'=>true,
            'isUploadBooks'=>false,
            'isMembers'=>false,
            'isBooks'=>false,
            'isAuthors'=>false,
            'isNews'=>false,
            'publishers'=>$publishers,
            'isSearch'=>true,
            'search'=>$request->input('search')
        ]);
    }
    public function searchAuthors(Request $request) {
        $authors = Author::where('name', $request->input('search'))
        ->orWhere('email', $request->input('search'))
        ->orWhere('phone', $request->input('search'))->paginate(8);
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>false, 
            'isMembers'=>false,
            'isBooks'=>false,
            'isAuthors'=>true,
            'isNews'=>false,
            'authors'=>$authors,
            'isSearch'=>true,
            'search'=>$request->input('search')
        ]);

    }
    public function searchMembers(Request $request) {
        $validatedData = $request->validate([
            'search'=>'required'
        ]);
        $members = User::join('members', 'users.id', '=', 'members.user_id')
        ->where('name', $request->input('search'))
        ->orWhere('surname', $request->input('search'))
        ->orWhere('email', $request->input('search'))
        ->orWhere('phone', $request->input('search'))->paginate(8);
        foreach($members as $member) {
            $member->age = Carbon::now()->year - Carbon::createFromFormat('Y-m-d', $member->birthday)->year;;
        }
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>false, 
            'isMembers'=>true,
            'isBooks'=>false,
            'isAuthors'=>false,
            'isNews'=>false,
            'members'=>$members,
            'isSearch'=>true,
            'search'=>$request->input('search')
        ]);
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
            'isNews'=>false,
            'bookTypes'=>$bookTypes,
            'numOfBook'=>$numOfBook,
            'isSearch'=>true,
            'search'=>$request->input('search')
        ]);
    }
    public function news() {
        $infos = Info::paginate(8);
        return view('web.admin.adminDashboard', [
            'isPublishers'=>false, 
            'isUploadBooks'=>false, 
            'isMembers'=>false,
            'isBooks'=>false, 
            'isAuthors'=>false,
            'isNews'=>true,
            'infos'=>$infos
        ]);
    }
    public function onCreateNews() {
        return view('web.admin.createNews');
    }
    public function createNews(Request $request) {
        $validatedData = $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);
        Info::create([
            'title'=>$request->input('title'),
            'description'=>$request->input('description')
        ]);
        return redirect('/admin-news');
    }
    public function onEditNews($newsId) {
        $news = Info::find($newsId);
        return view('web.admin.editNews', ['news'=>$news]);
    }
    public function editNews(Request $request, $newsId) {
        $validatedData = $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);
        Info::find($newsId)->update([
            'title'=>$request->input('title'),
            'description'=>$request->input('description')
        ]);
        return redirect('/admin-news');
    }
    public function deleteNews(Request $request) {
        $validatedData = $request->validate([
            'newsId'=>'required',
        ]);
        Info::find($request->input('newsId'))->delete();
        return redirect('/admin-news');
    }
}
