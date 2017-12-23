@extends('web.templates.app') 
@section('title', 'Info') 
@section('header') 
@include('web.components.header') 
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-header">
            <h3>หัวข้อ: {{$info->title}}</h3>
            <h6>{{$info->created_at}}</h6>
        </div>
        <div class="card-body">
            <h4>รายละเอียด:</h4>
            <p>{{$info->description}}</p>
        </div>
    </div>
@endsection