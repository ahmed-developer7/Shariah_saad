@extends('layouts/contentLayoutMaster')

@section('title', empty($product_classification) ? 'Add Product Classification' : 'Edit Product Classification')

@section('content')
    <add-product-classification-component :product-classification="{{json_encode($product_classification)}}" :user="{{json_encode(Auth::user())}}"></add-product-classification-component>
@endsection
