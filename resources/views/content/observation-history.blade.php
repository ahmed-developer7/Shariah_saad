@extends('layouts/contentLayoutMaster')

@section('title', 'Observation History')

@section('content')
    <observation-history-component :id="{{json_encode($id)}}"></observation-history-component>
@endsection
