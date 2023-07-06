@extends('layouts/contentLayoutMaster')

@section('title', 'Home')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Shariyah Review Bureau</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <a href="/admin/add-project">
                        <div style="border: 1px solid lightgray; border-radius: 5px; height: 150px; background-color: #f8f8f8">
                            <span style="display: block; text-align: center; position: relative; top: 40%; font-size: 24px">Create Project</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <a href="/admin/add-company">
                        <div style="border: 1px solid lightgray; border-radius: 5px; height: 150px; background-color: #f8f8f8">
                            <span style="display: block; text-align: center; position: relative; top: 40%; font-size: 24px">Create Client</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12" style="margin: 0 auto; display: block">
                    <a href="/admin/add-observation">
                        <div style="border: 1px solid lightgray; border-radius: 5px; height: 150px; background-color: #f8f8f8">
                            <span style="display: block; text-align: center; position: relative; top: 40%; font-size: 24px">Create Observation</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <a href="/admin/mm-report">
                        <div style="border: 1px solid lightgray; border-radius: 5px; height: 150px; background-color: #f8f8f8">
                            <span style="display: block; text-align: center; position: relative; top: 40%; font-size: 24px">Create MM Report</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
