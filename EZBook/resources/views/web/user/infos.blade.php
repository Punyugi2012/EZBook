@extends('web.templates.app')
@section('title', 'Infos')
@section('header')
    @include('web.components.header')
@endseciton
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-header">
            ข่าวสาร ทั้งหมด
        </div>
        <div class="card-body">
            <div class="row">
             @foreach($infos as $info)
                <div class="col-md-12 text-center">
                    <a href="/info/{{$info->id}}">{{$info->created_at}} <span style="margin-left:50px">{{$info->title}}</span></a>
                </div>
            @endforeach
            </div>
        </div>
        <div class="card-footer">
            {{$infos->links()}}
        </div>
    </div>
@endsection