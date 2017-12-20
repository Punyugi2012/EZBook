@extends('web.templates.app')
@section('title', 'CreateNews')
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
    <div class="border border-secondary rounded" style="padding: 50px; margin-top: 30px">
        <h1>เพิ่ม ข่าวสาร</h1>
        <form action="/admin-create-news" method="POST" autocomplete="off">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title">หัวข้อ:</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="หัวข้อ" required>
            </div>
            <div class="form-group">
                <label for="description">รายละเอียด:</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="รายละเอียด"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">เพิ่ม</button>
            <button type="reset" class="btn btn-warning">ล้าง</button>
        </form>
    </div>
@endsection