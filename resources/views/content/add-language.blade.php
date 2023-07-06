@extends('layouts/contentLayoutMaster')

@section('title', empty($language) ? 'Add Language' : 'Edit Language')

@section('content')
    <add-language-component :language="{{json_encode($language)}}" :user="{{json_encode(Auth::user())}}"></add-language-component>
@endsection
