@extends('layouts/contentLayoutMaster')

@section('title', 'Project History')

@section('content')
    <project-history-component :id="{{json_encode($id)}}"></project-history-component>
@endsection
