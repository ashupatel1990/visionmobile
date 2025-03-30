@extends('layout.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <!-- <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Extras</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div> -->
                <h4 class="page-title">Profile</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card-box text-center">
                @if($admin->profile_image)
                    <img src="{{asset('admin/users/'. $admin->profile_image )}}" class="rounded-circle avatar-lg img-thumbnail" alt="{{$admin->name}}">
                @else
                    <img src="../assets/images/users/user-1.jpg" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                @endif
                <h4 class="mb-0">{{ $admin->name }}</h4>

                <div class="text-left mt-3">
                    <h4 class="font-13 text-uppercase">About Me :</h4>
                    <!-- <p class="text-muted font-13 mb-3">
                        Hi I'm Johnathn Deo,has been the industry's standard dummy text ever since the
                        1500s, when an unknown printer took a galley of type.
                    </p> -->
                    <p class="text-muted mb-2 font-13"><strong>Username :</strong> <span class="ml-2">{{ $admin->username }}</span></p>
                    <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2">{{ $admin->name }}</span></p>

                    <!-- <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2">(123)123 1234</span></p> -->

                    <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 ">{{ $admin->email }}</span></p>
                </div>

            </div> <!-- end card-box -->

        </div> <!-- end col-->

        <div class="col-lg-8 col-xl-8">
            <div class="card-box">
                <div class="tab-content">
                    <div class="tab-pane active" id="settings">
                        <form method="POST" action="{{ route('store.profile') }}" enctype="multipart/form-data">
                            @csrf
                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">User Name</label>
                                        <input type="text" class="form-control" name="username" id="username" value="{{$admin->username}}" placeholder="Enter first name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname">Name</label>
                                        <input type="text" class="form-control" name="name" id="lastname" value="{{$admin->name}}" placeholder="Enter last name">
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="useremail">Email Address</label>
                                        <input type="email" class="form-control" name="email" value="{{$admin->email}}" id="useremail" placeholder="Enter email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profilephoto">Profile Photo</label>
                                        <input type="file" class="form-control" name="profile_image" id="profilephoto" placeholder="">
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                    <!-- end settings content-->

                </div> <!-- end tab-content -->
            </div> <!-- end card-box-->

        </div> <!-- end col -->
    </div>
    <!-- end row-->

</div>
@endsection