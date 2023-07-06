@extends('layouts/contentLayoutMaster')

@section('title', empty($employee) ? 'Add Employee' : 'Edit Employee')

@section('content')
    <add-employee-component :employee="{{json_encode($employee)}}" :user="{{json_encode(Auth::user())}}"></add-employee-component>
@endsection
