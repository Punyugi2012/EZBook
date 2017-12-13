@extends('web.templates.app')
@section('title', 'Dashboard')
@section('header')
    <nav class="navbar navbar-light bg-light justify-content-between">
        <span>
            <a class="navbar-brand">EZBooks</a>
            Search a book
        </span>
        <span>
            <a href="/admin-logout" class="btn btn-primary">Logout</a>
        </span>
    </nav>
@endsection
@section('content')
    <style>
        .nav li {
            margin-left: 5px;
        }
    </style>
    <div style="margin-top:20px">
        <ul class="nav nav-pills flex-column flex-sm-row">
            <li class="nav-item">
                <a class="nav-link btn btn-light {{$isPublishers?'active':''}}" href="/admin-publishers">สำนักพิมพ์</a>
            </li>
             <li class="nav-item">
                <a class="nav-link btn btn-light {{$isUploadBooks?'active':''}}" href="/admin-uploadbooks">เพิ่มหนังสือ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-light {{$isMembers?'active':''}}" href="/admin-members">สมาชิก</a>
            </li>
        </ul>
    </div>
    <div>
        @if($isPublishers)
            <div class="card" style="margin-top:10px">
                <div class="card-header">
                    สำนักพิมพ์
                </div>
                <div class="card-body">
                    <a href="/admin-regis-publisher" class="btn btn-info">เพิ่มสำนักพิมพ์</a>
                    <table class="table table-striped" style="margin-top:10px">
                        <thead>
                            <tr>
                            <th>ชื่อ</th>
                            <th>ที่อยู่</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>อีเมลล์</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($publishers as $publisher)
                                <tr>
                                    <td>{{$publisher->name}}</td>
                                    <td>{{$publisher->address}}</td>
                                    <td>{{$publisher->phone}}</td>
                                    <td>{{$publisher->email}}</td>
                                    <td>{{$publisher->username}}</td>
                                    <td>{{$publisher->password}}</td>
                                    <td>{{$publisher->created_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($isUploadBooks)
             <div class="card" style="margin-top:10px">
                <div class="card-header">
                    เพิ่มหนังสือ
                </div>
                <div class="card-body">
              
                </div>
            </div>
        @elseif($isMembers)
             <div class="card" style="margin-top:10px">
                <div class="card-header">
                    สมาชิก
                </div>
                <div class="card-body">
        
                </div>
            </div>
        @endif
    </div>
@endsection
@section('footer')
    @include('web.components.footer')
@endsection
    