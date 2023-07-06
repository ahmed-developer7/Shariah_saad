@extends('layouts/contentLayoutMaster')

@section('title', empty($productType) ? 'Add Product Type' : 'Edit Product Type')

@section('content')
    <add-product-type-component :product-type="{{json_encode($productType)}}" :user="{{json_encode(Auth::user())}}"></add-product-type-component>
@endsection
