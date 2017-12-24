@extends('web.templates.app')
@section('title', 'ข่าวสาร')
@section('header')
    @include('web.components.header')
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-header">
            <span style="font-size:20px">
                ข่าวสาร ทั้งหมด, <a href="javascript:void(0)">{{$infos->total()}}</a>
            </span>
        </div>
        <div class="card-body">
            @if (count($infos) == 0)
            <div class="alert alert-warning text-center">
                ไม่พบข่าวสาร
            </div>
            @endif
            <div class="row">
             @foreach($infos as $info)
                <div class="col-md-12 text-center">
                    <a href="/info/{{$info->id}}">{{formatDateThai($info->created_at)}} <span style="margin-left:50px">{{$info->title}}</span></a>
                </div>
            @endforeach
            </div>
        </div>
        <div>
            {{$infos->links()}}
        </div>
    </div>
    <div style="margin-bottom:300px">
    </div>
@endsection