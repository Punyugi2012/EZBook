@extends('web.templates.app')
@section('title', 'Login')
    @include('web.components.header')
@section('content')
     <div class="border border-secondary rounded" style="padding: 50px; margin-top: 100px">
        <h1>สำนักพิมพ์/นักเขียน เข้าสู่ระบบ</h1>
        <form action="publisher-login" method="POST" autocomplete="off">
            {{ csrf_field() }}
             <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
            </div>
            <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
        </form>
    </div>
@endsection