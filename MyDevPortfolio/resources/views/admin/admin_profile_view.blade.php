@extends('admin.adminMaster')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <center><br><br>
                        <img class="rounded-circle avatar-lg" src="{{asset('backend/assets/images/small/img-5.jpg')}}" alt="Card image cap">
                    </center>
                    <div class="card-body">
                        <h4 class="card-title">Name : {{$adminData -> name}}</h4>
                        <hr>
                        <h4 class="card-title">User Name : {{ $adminData -> username }}</h4>
                        <hr>
                        <h4 class="card-title">Email : {{$adminData -> email}}</h4>
                        <hr>
                        <a href="{{ route('edit.profile')}}" class="btn btn-info waves-effect waves-light">Edit Profile</a>
                    </div>
                </div>
            </div>

        </div>



    </div>
</div>


@endsection