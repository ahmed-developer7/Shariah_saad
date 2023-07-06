@extends('layouts/contentLayoutMaster')

@section('title', 'Projects')

@section('content')
    @if (\Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li style="padding: 10px">{!! \Session::get('message') !!}</li>
            </ul>
        </div>
    @elseif (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                <li style="padding: 10px">{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif
    <project-component :id="{{json_encode($id)}}" :user_id="{{json_encode($user_id)}}" :data="{{json_encode(null)}}" :year_range_1="{{json_encode(null)}}" :year_range_2="{{json_encode(null)}}"></project-component>
@endsection
