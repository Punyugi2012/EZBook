@extends('web.templates.app')
@section('title', 'publisher register')
@section('header')
    <nav class="navbar navbar-light bg-light justify-content-between">
        <span>
            <a href="/admin-dashboard" class="navbar-brand">EZBooks</a>
        </span>
        <span>
            <a href="/admin-logout" class="btn btn-primary">Logout</a>
        </span>
    </nav>
@endsection
@section('content')
    <a href='/admin-authors' class="btn btn-primary" style="margin-top: 10px">ย้อนกลับ</a>
    <div class="border border-secondary rounded" style="padding: 50px; margin-top: 30px">
        <h1>เพิ่ม ผู้แต่ง</h1>
        <form action="/admin-create-author" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">ชื่อ:</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="name" required>
            </div>
            <div class="form-group">
                <label for="email">อีเมลล์:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="email" required>
            </div>
            <div class="form-group">
                <label for="phone">เบอร์โทรศัพท์:</label>
                <input type="number" class="form-control" name="phone" id="phone" placeholder="phone" required>
            </div>
            <button type="submit" class="btn btn-primary">เพิ่ม</button>
            <button type="reset" class="btn btn-warning">ล้าง</button>
        </form>
    </div>
@endsection