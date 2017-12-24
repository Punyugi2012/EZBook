@extends('web.templates.app') 
@section('title', 'ข่าวสาร') 
@section('header') 
@include('web.components.header') 
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-body">
            <h3>หัวข้อ: {{$info->title}}</h3>
            <h6>{{formatDateThai($info->created_at)}}</h6>
            <br>
            <h4>รายละเอียด:</h4>
            <p>{{$info->description}}</p>
        </div>
    </div>
    <div style="margin-bottom:400px">
    </div>
@endsection