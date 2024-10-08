@extends('admin.adminMaster')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Profil Page</h4>
                        <form method="post" action="{{route('store.profile')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input id="example-text-input" class="form-control" type="text" name="name" value="{{$editData->name}}">
                                </div>
                            </div>
                             <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">User Name</label>
                                <div class="col-sm-10">
                                    <input id="username" class="form-control" type="text" name="username" value="{{$editData->username}}">
                                </div>
                            </div>
                             <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input id="email" class="form-control" type="email" name="email" value="{{$editData->email}}">
                                </div>
                            </div>
                             <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Profile Image</label>
                                <div class="col-sm-10">
                                    <input id="image" class="form-control" type="file" name="profile_image" >
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <img id="showImage" class="rounded avatar-lg" src="{{asset('backend/assets/images/small/img-5.jpg')}}" alt="Card image cap">
                            </div>
                            <!-- end row -->
                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Profile">
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>


    </div>
</div>

<script type="text/javascript"> 

    $(document).ready(function(){
        $('#image').change(function(e){
           var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>

@endsection