@extends('layouts/contentLayoutMaster')

@section('title', 'Export')

@section('content')
    <excel-export-component :id="{{json_encode($id)}}" :user_id="{{json_encode($user_id)}}"></excel-export-component>
@endsection
