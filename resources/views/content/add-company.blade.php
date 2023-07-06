@extends('layouts/contentLayoutMaster')

@section('title', empty($company) ? 'Add Client' : 'Edit Client')

@section('content')
    <add-company-component :company="{{json_encode($company)}}" :user="{{json_encode(Auth::user())}}"></add-company-component>
@endsection
