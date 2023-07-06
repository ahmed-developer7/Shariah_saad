@extends('layouts/contentLayoutMaster')

@section('title', 'Update Password')

@section('content')
    @if($errors->any())
        <p style="color: red">• {{$errors->first()}}</p>
    @endif
    <div class="container-fluid add-project">
        <form action="{{route('update-password')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Old Password</label>
                    <input class="project-text" type="text" name="old_password" placeholder="Enter old password"
                           required>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>New Password</label>
                    <input class="project-text" type="text" name="password" placeholder="Enter new password" required>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Confirm Password</label>
                    <input class="project-text" type="text" name="confirm_password" placeholder="Enter password again" required>
                </div>
            </div>
            <input type="submit" value="Update" class="btn btn-primary submit editSubmit">
        </form>
    </div>
@endsection
