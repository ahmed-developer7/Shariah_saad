@extends('layouts/contentLayoutMaster')

@section('title', empty($document) ? 'Add Product Document' : 'Edit Product Document')

@section('content')
    <add-product-document-component :document="{{json_encode($document)}}"></add-product-document-component>
@endsection
