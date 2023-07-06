@extends('layouts/contentLayoutMaster')

@section('title', empty($scholar) ? 'Add Scholar' : 'Edit Scholar')

@section('content')
    <add-scholar-component :scholar="{{json_encode($scholar)}}" :user="{{json_encode(Auth::user())}}"></add-scholar-component>
@endsection
