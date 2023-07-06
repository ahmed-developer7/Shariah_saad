@extends('layouts/contentLayoutMaster')

@section('title', empty($user) ? 'Add User' : 'Edit User')

@section('content')
    <add-user-component :user="{{json_encode($user)}}" :current-user="{{json_encode(Auth::user())}}"></add-user-component>
@endsection
