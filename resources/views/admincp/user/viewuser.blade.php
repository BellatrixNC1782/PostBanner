@extends('Layouts.appadmin')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!--Page header-->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <h4 class="page-title mb-0">View User Profile</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fe fe-layers me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('userlist') }}">User Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>View User Profile</a></li>
                </ol>
            </div>
        </div>

        @if(!empty($user_data))
        <div class="main-proifle p-0">
            <div class="row p-4">
                <div class="col-xl-8 col-lg-12">
                    <div class="box-widget widget-user">
                        <div class="widget-user-image1 d-sm-flex">
                            @if(!empty($user_data['image']))
                            <img alt="User Avatar" class="rounded-circle border p-0 img-fluid" width="130" src="{{ asset('public/uploads/'.$user_data->image) }}">
                            @else
                            <img alt="User Avatar" class="rounded-circle border p-0 img-fluid" width="130" src="{{ asset('public/images/default.png') }} ">
                            @endif
                            <div class="mt-1 ms-sm-2">
                                <h4 class="pro-user-username mb-3 fw-bold">{{ $user_data->first_name }} {{ $user_data->last_name }}</h4>
                                <ul class="mb-0 pro-details list-unstyled">
                                    <li><span class="profile-icon"><i class="fe fe-mail"></i></span><span class="h6 mb-0">{{ $user_data->email }}</span></li>
                                    @if(!empty($user_data['mobile']))
                                    <li><span class="profile-icon"><i class="fe fe-phone-call"></i></span><span class="h6 mb-0">{{ substr($user_data['mobile'], 0, 3) .'-'. substr($user_data['mobile'], 3, 3) .'-'.substr($user_data['mobile'], 6)}}</span></li>
                                    @endif
                                    <li>
                                        @if($user_data->status == 'active')
                                        <span class="profile-icon"><i class="fe fe-check"></i></span>
                                        <span class="h6 mb-0" style="color: #00bf00;">Active</span>
                                        @else
                                        <span class="profile-icon"><i class="fe fe-x"></i></span>
                                        <span class="h6 mb-0" style="color: #dc3545;">Inactive</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        @endif
        
       
       

    </div>
</div>
@endsection

@section('javascript')
<script>
    

</script>
@endsection
