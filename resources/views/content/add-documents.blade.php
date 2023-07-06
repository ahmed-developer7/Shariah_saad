@extends('layouts/contentLayoutMaster')

@section('title', $type == 'add' ? 'Add Documents' : 'Amend Documents')

@section('content')
    <add-documents-component :id="{{json_encode($id)}}" :type="{{json_encode($type)}}" :documents="{{json_encode($documents)}}"></add-documents-component>
@endsection
