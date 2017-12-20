@extends('web.templates.app')
@section('title', 'EditNews')
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
        <h1>แก้ไข ข่าวสาร</h1>
        <form action="/admin-edit-news/{{$news->id}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="title">หัวข้อ:</label>
                <input type="text" class="form-control" name="title" id="title" value="{{$news->title}}" required>
            </div>
            <div class="form-group">
                <label for="description">รายละเอียด:</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{$news->description}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">บันทึก</button>
            <button type="reset" class="btn btn-warning">ล้าง</button>
        </form>
    </div>
@endsection