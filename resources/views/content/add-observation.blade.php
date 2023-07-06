@extends('layouts/contentLayoutMaster')

@section('title', empty($observation) ? 'Add Observation' : 'Edit Observation')

@section('content')
    <add-observation-component :observation="{{json_encode($observation)}}"></add-observation-component>
@endsection
