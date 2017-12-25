@extends('web.templates.app')
@section('title', 'ข้อมูลส่วนตัว')
@section('header')
    @include('web.components.header')
@endsection
@section('content')
    <div style="margin-top:80px">
    <div>
        <div class="card">
            <div class="card-header">
                 <a class="navbar-brand" href="/user-profile"><h1>ข้อมูลส่วนตัว</h1></a>
            </div>
            @if (session()->has('updatedUser'))
            <div class="alert alert-success text-center">
                {{session()->get('updatedUser')}}
            </div>
            @elseif(session()->has('updatedAccount'))
            <div class="alert alert-success text-center">
                {{session()->get('updatedAccount')}}
            </div>
            @elseif(session()->has('createdAccount'))
            <div class="alert alert-success text-center">
                {{session()->get('createdAccount')}}
            </div>
            @endif
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-md-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link {{$hasQuery?'':'active'}}" id="tab-profile" data-toggle="pill" href="#profile" role="tab" aria-selected="true">ข้อมูลส่วนตัว</a>
                    <a class="nav-link" id="tab-edit-profile" data-toggle="pill" href="#edit-profile" role="tab" aria-selected="false">แก้ไขข้อมูลส่วนตัว</a>
                    <a class="nav-link" id="tab-account" data-toggle="pill" href="#account" role="tab" aria-selected="false">บัญชี</a>
                    <a class="nav-link" id="tab-edit_account" data-toggle="pill" href="#edit_account" role="tab" aria-selected="false">แก้ไขบัญชี</a>
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
                                        <img src="{{session()->get('user')->member->url_image }}" class="rounded-circle img-thumbnail" style="width:150px;height:150px">
                                    @else 
                                        <img  src="https://cdn0.iconfinder.com/data/icons/users-android-l-lollipop-icon-pack/24/user-512.png" class="rounded-circle img-thumbnail" style="width:150px;height:150px">
                                    @endif
                                </div>
                                <p class="card-text">เลขที่บัตรประชาชน: {{session()->get('user')->member->id_card}}</p>
                                <p class="card-text">ชื่อ: {{session()->get('user')->member->name}}</p>
                                <p class="card-text">นามสกุล: {{session()->get('user')->member->surname}}</p>
                                <p class="card-text">เบอร์โทรศัพท์: {{session()->get('user')->member->phone}}</p>
                                <p class="card-text">อีเมลล์: {{session()->get('user')->email}}</p>
                                <p class="card-text">ที่อยู่: {{session()->get('user')->member->address}}</p>
                                <p class="card-text">เพศ: {{session()->get('user')->member->gender == 'male' ? 'ชาย' : 'หญิง'}}</p>
                                <p class="card-text">วันเกิด: {{formatDateThai(session()->get('user')->member->birthday)}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="edit-profile" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-8" style="border-right:1px solid grey">
                                        <form action="/user-update/{{session()->get('user')->member->id}}" method="POST" autocomplete="off">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                            <div class="form-group">
                                                <label for="id_card"><span style="color:red">*</span>เลขที่บัตรประชาชน:</label>
                                                <input type="text" class="form-control" name="id_card" value="{{session()->get('user')->member->id_card}}" id="id_card" placeholder="เลขที่บัตรประชาชน" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name"><span style="color:red">*</span>ชื่อ:</label>
                                                <input type="text" class="form-control" name="name" value="{{session()->get('user')->member->name}}" id="name" placeholder="ชื่อ" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="surname"><span style="color:red">*</span>นามสกุล:</label>
                                                <input type="text" class="form-control" name="surname" value="{{session()->get('user')->member->surname}}" id="surname" placeholder="นามสกุล" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone"><span style="color:red">*</span>เบอร์โทรศัพท์:</label>
                                                <input type="number" class="form-control" name="phone" value="{{session()->get('user')->member->phone}}" id="phone" placeholder="เบอร์โทรศัพท์" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="address"><span style="color:red">*</span>ที่อยู่:</label>
                                                <input type="text" class="form-control" name="address" value="{{session()->get('user')->member->address}}" id="address" placeholder="ที่อยู่" required>
                                            </div>
                                            <span style="color:red">*</span>เพศ:
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
                                                <label for="birthday"><span style="color:red">*</span>วันเกิด:</label>
                                                <input type="date" name="birthday" id="birthday" value="{{session()->get('user')->member->birthday}}" class="form-control" required>
                                            </div>
                                            <div class="text-center" style="margin-top:50px">
                                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                                <button type="reset" class="btn btn-warning">ล้าง</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <img src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-9/512/Warning-icon.png" alt="warning" style="width:200px;height:200px">
                                        </div>
                                        <p><span style="color:red">*</span>กรุณาตรวจสอบความถูกต้องก่อนกดบันทึก</p>
                                    </div>
                                </div>
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
                                                <td>{{formatDateThai($purchase->date_purchase)}}</td>
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
                    <div class="tab-pane fade" id="account" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="text-center">การผูกบัตรเครดิต</h1>
                                @if(session()->get('user')->member->account)
                                    <p>เลขที่บัญชี: {{session()->get('user')->member->account->account_number}}</p>
                                    <p>วันหมดอายุ: {{formatDateThai(session()->get('user')->member->account->expired_date)}}</p>
                                    <p>CVV: {{session()->get('user')->member->account->cvv}}</p>
                                    <p>ผูกเมื่อ {{formatDateThai(session()->get('user')->member->account->created_at)}}</p>
                                    <p>แก้ไขเมื่อ {{formatDateThai(session()->get('user')->member->account->updated_at)}}</p>
                                @else
                                    <div class="alert alert-warning text-center">
                                        ท่านยังไม่ได้ผูกบัตรเครดิตกับระบบ กด<button data-toggle="modal" data-target="#bind">ผูกบัตรเครดิต</button>เพื่อผูกบัตรเครดิตกับระบบ
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal fade" id="bind" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">การผูกบัตรเครดิต</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/user-bind" method="post" autocomplete="off">
                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                        <div class="text-center">
                                        <img src="https://dharmamerchantservices.com/wp-content/uploads/2017/06/visa.jpg" alt="visa" style="width:100px;height:50px">
                                        <img src="https://xl-id.com/media/1149/mastercard.png" alt="mastercard" style="width:50px;height:50px">
                                        <img src="http://www.global.jcb/en/common/images/svg/jcb_emblem_logo.svg" alt="jcb" style="width:50px;height:50px">
                                        </div>
                                        <div class="form-group">
                                            <label for="account_number"><span style="color:red">*</span>เลขที่บัตร:</label>
                                            <input type="text" name="account_number" id="account_number" class="form-control" placeholder="เลขที่บัตร" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="expired_date"><span style="color:red">*</span>วันหมดอายุ:</label>
                                            <input type="month" name="expired_date" id="expired_date" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="cvv"><span style="color:red">*</span>CVV:</label>
                                            <input type="text" name="cvv" id="cvv" class="form-control" placeholder="CVV" required>
                                        </div>
                                        <p><span style="color:red">*</span>กรุณาตรวจสอบความถูกต้องก่อนกดบันทึก</p>
                                        <p><span style="color:red">*</span>กรุณากรอกข้อมูลให้ครบถ้วน</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="edit_account" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8" style="border-right:1px solid grey">
                                        <h1 class="text-center">
                                            แก้ไขการผูกบัตรเครดิต
                                            <div>
                                                <img src="https://dharmamerchantservices.com/wp-content/uploads/2017/06/visa.jpg" alt="visa" style="width:100px;height:50px">
                                                <img src="https://xl-id.com/media/1149/mastercard.png" alt="mastercard" style="width:50px;height:50px">
                                                <img src="http://www.global.jcb/en/common/images/svg/jcb_emblem_logo.svg" alt="jcb" style="width:50px;height:50px">
                                            </div>
                                        </h1>
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                        @if (session()->get('user')->member->account)
                                            <form action="/user-edit-bind/{{session()->get('user')->member->account->id}}" method="POST" autocomplete="off">
                                                {{ csrf_field() }}
                                                {{method_field('PUT')}}
                                                <div class="form-group">
                                                    <label for="edit_account_number"><span style="color:red">*</span>เลขที่บัญชี:</label>
                                                    <input type="text" name="edit_account_number" id="edit_account_number" class="form-control" value="{{session()->get('user')->member->account->account_number}}" placeholder="เลขที่บัญชี" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_expired_date"><span style="color:red">*</span>วันหมดอายุ:</label>
                                                    <input type="month" name="edit_expired_date" id="edit_expired_date" class="form-control" value="{{session()->get('user')->member->account->expired_date}}" placeholder="วันหมดอายุ" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_cvv"><span style="color:red">*</span>CVV:</label>
                                                    <input type="text" name="edit_cvv" id="edit_cvv" class="form-control" value="{{session()->get('user')->member->account->cvv}}" placeholder="CVV"  required>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    <button type="reset" class="btn btn-warning">ล้าง</button>
                                                </div>
                                            </form>
                                        @else
                                            <div class="alert alert-warning text-center">
                                                ท่านยังไม่ได้ผูกบัตรเครดิตกับระบบ กดที่เมนูบัญชีเพื่อผูกบัตรเครดิตกับระบบ
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <img src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-9/512/Warning-icon.png" alt="warning" style="width:200px;height:200px">
                                        </div>
                                        <p><span style="color:red">*</span>กรุณาตรวจสอบข้อมูลก่อนกดบันทึก</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    </div>
    <div style="margin-bottom:300px">
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