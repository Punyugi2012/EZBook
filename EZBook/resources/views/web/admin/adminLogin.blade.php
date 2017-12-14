@extends('web.templates.app')
@section('title', 'AdminLogin')
@section('header')
    @include('web.components.header')
@endsection
@section('content')
    <div class="border border-secondary rounded" style="padding: 50px; margin-top: 50px">
        <h1>Admin Login</h1>
        <form action="admin-login" method="POST">
            {{ csrf_field() }}
             <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="reset" class="btn btn-warning">Clear</button>
        </form>
    </div>
@endsection
@section('footer')
    @include('web.components.footer')
@endsection
    