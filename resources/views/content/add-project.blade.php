@extends('layouts/contentLayoutMaster')

@php
    if (isset($duplicate) && $duplicate) {
        $duplicate = true;
    } else {
        $duplicate = false;
    }
@endphp

@section('title', empty($project) ? 'Add Project' : ($duplicate ? 'Duplicate Project' : 'Edit Project'))

@section('content')
    <add-project-component :project="{{json_encode($project)}}" :user="{{json_encode(Auth::user())}}" :duplicate="{{json_encode($duplicate)}}"></add-project-component>
@endsection
