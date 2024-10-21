@extends('admin.adminMaster')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Home Slide Page</h4>
                        <form method="post" action="{{route('update.slider')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input id="example-text-input" class="form-control" type="text" name="title" value="{{$homeslide->title}}">
                                </div>
                            </div>
                             <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Short Title </label>
                                <div class="col-sm-10">
                                    <input id="short_title" class="form-control" type="text" name="short_title" value="{{$homeslide->short_title}}">
                                </div>
                            </div>
                             <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Video URL</label>
                                <div class="col-sm-10">
                                    <input id="video_url" class="form-control" type="text" name="video_url" value="{{$homeslide->video_url}}">
                                </div>
                            </div>
                             <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Slider Image</label>
                                <div class="col-sm-10">
                                    <input id="image" class="form-control" type="file" name="home_slide" >
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <img id="showImage" class="rounded avatar-lg" src="{{ (!empty($homeslide->profile_image))? url('upload/home_slide/'.$homeslide->profile_image):url('upload/no_image.jpg') }}" alt="Card image cap">
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