@extends('layouts/contentLayoutMaster')

@section('title', empty($sector) ? 'Add Sector' : 'Edit Sector')

@section('content')
    <add-sector-component :sector="{{json_encode($sector)}}" :user="{{json_encode(Auth::user())}}"></add-sector-component>
@endsection
