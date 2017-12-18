@extends('web.templates.app')
@section('title', 'Login')
    @include('web.components.header')
@section('content')
     <div class="border border-secondary rounded" style="padding: 50px; margin-top: 100px">
        <h1>เข้าสู่ระบบ</h1>
        <form action="user-login" method="POST">
            {{ csrf_field() }}
             <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
            </div>
            <a href="/user-register">สมัครสมาชิก</a>
            <div style="margin-top:5px" class="text-center">
                <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
            </div>
        </form>
    </div>
@endsection