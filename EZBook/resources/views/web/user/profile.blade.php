@extends('web.templates.app')
@section('title', 'Profile')
@section('header')
    @include('web.components.header')
@endseciton
@section('content')
    <div style="margin-top:80px">
    <div>
        <div class="card">
            <div class="card-header">
                 <a class="navbar-brand" href="/user-profile"><h1>ข้อมูลส่วนตัว</h1></a>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-md-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link {{$hasQuery?'':'active'}}" id="tab-profile" data-toggle="pill" href="#profile" role="tab" aria-selected="true">ข้อมูลส่วนตัว</a>
                    <a class="nav-link" id="tab-edit-profile" data-toggle="pill" href="#edit-profile" role="tab" aria-selected="false">แก้ไขข้อมูลส่วนตัว</a>
                    <a class="nav-link {{$hasQuery?'active':''}}" id="tab-history" data-toggle="pill" href="#history" role="tab" aria-selected="false">ประวัติการซื้อ</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade {{$hasQuery?'':'show active'}}" id="profile" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    @if(session()->get('user')->member->url_image != "/storage/")
                                        <img src="{{session()->get('user')->member->url_image }}" class="rounded-circle" style="width:150px;height:150px">
                                    @else 
                                        <img src="https://cdn0.iconfinder.com/data/icons/users-android-l-lollipop-icon-pack/24/user-512.png" class="rounded-circle" style="width:150px;height:150px">
                                    @endif
                                </div>
                                <p class="card-text">เลขที่บัตรประชาชน: {{session()->get('user')->member->id_card}}</p>
                                <p class="card-text">ชื่อ: {{session()->get('user')->member->name}}</p>
                                <p class="card-text">นามสกุล: {{session()->get('user')->member->surname}}</p>
                                <p class="card-text">เบอร์โทรศัพท์: {{session()->get('user')->member->phone}}</p>
                                <p class="card-text">อีเมลล์: {{session()->get('user')->email}}</p>
                                <p class="card-text">ที่อยู่: {{session()->get('user')->member->address}}</p>
                                <p class="card-text">เพศ: {{session()->get('user')->member->gender}}</p>
                                <p class="card-text">วันเกิด: {{session()->get('user')->member->birthday}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="edit-profile" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <form action="/user-update/{{session()->get('user')->member->id}}" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="form-group text-center" style="margin-top:10px">
                                        <img id="blah" src="" alt="image" style="width:150px;height:150px" class="rounded-circle"/>
                                        <br>
                                        <label for="image">รูป:</label>
                                        <input type="file" class="form-control" name="image" id="image">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_card">ชื่อ:</label>
                                        <input type="text" class="form-control" name="id_card" value="{{session()->get('user')->member->id_card}}" id="id_card" placeholder="เลขที่บัตรประชาชน" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">ชื่อ:</label>
                                        <input type="text" class="form-control" name="name" value="{{session()->get('user')->member->name}}" id="name" placeholder="ชื่อ" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="surname">นามสกุล:</label>
                                        <input type="text" class="form-control" name="surname" value="{{session()->get('user')->member->surname}}" id="surname" placeholder="นามสกุล" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">เบอร์โทรศัพท์:</label>
                                        <input type="number" class="form-control" name="phone" value="{{session()->get('user')->member->phone}}" id="phone" placeholder="เบอร์โทรศัพท์" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">ที่อยุ่:</label>
                                        <input type="text" class="form-control" name="address" value="{{session()->get('user')->member->address}}" id="address" placeholder="ที่อยู่" required>
                                    </div>
                                    เพศ:
                                    <div class="form-group">
                                        <div class="form-check d-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="gender" id="gender" value="male" {{session()->get('user')->member->gender == 'male' ? 'checked' : ''}}>
                                            เพศชาย
                                        </label>
                                        </div>
                                        <div class="form-check d-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="gender" id="gender" value="female" {{session()->get('user')->member->gender == 'female' ? 'checked' : ''}}>
                                            เพศหญิง
                                        </label>
                                        </div>
                                    </div>
                                    <div class"form-group">
                                        <label for="birthday">วันเกิด:</label>
                                        <input type="date" name="birthday" id="birthday" value="{{session()->get('user')->member->birthday}}" class="form-control" required>
                                    </div>
                                    <div class="text-center" style="margin-top:50px">
                                        <button type="submit" class="btn btn-success">ยืนยัน</button>
                                        <button type="reset" class="btn btn-warning">ล้าง</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{$hasQuery?'show active':''}}" id="history" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">วัน/เดือน/ปี/เวลา</th>
                                            <th scope="col">ชื่อหนังสือ</th>
                                            <th scope="col">ราคา</th>
                                            <th scope="col">ประเภท</th>
                                            <th scope="col">สำนักพิมพ์/นักเขียน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchases as $purchase)
                                             <tr>
                                                <td>{{$purchase->date_purchase}}</td>
                                                <td>
                                                    <a href="/book/{{$purchase->book->id}}">{{$purchase->book->name}}</a>
                                                </td>
                                                <td>{{$purchase->price}}</td>
                                                <td>{{$purchase->book->bookType->name}}</td>
                                            
                                                <td>
                                                    <a href="/user-books/publisher/{{$purchase->book->publisher->id}}">
                                                        {{$purchase->book->publisher->name}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$purchases->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    </div>
@endsection
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
             function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#blah').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#image").on('change', function() {
                readURL(this);
            });   
        });
    </script>
@endsection