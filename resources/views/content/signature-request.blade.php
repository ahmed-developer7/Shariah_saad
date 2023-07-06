@extends('layouts/fullLayoutMaster')

@section('title', 'Signature Pad')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
    <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
          rel="stylesheet">
@endsection

@section('content')
    <div class="auth-wrapper auth-basic px-2 signature-pad">
        <div class="auth-inner my-2">
            <div class="card mb-0" style="border-radius: 7px">
                <div class="card-body">
                    <a class="brand-logo login-logo" href="{{url('/login')}}">
                        <img src="{{url('images/logo.png')}}" class="img-fluid" alt="Brand logo">
                    </a>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success  alert-dismissible">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($error = Session::get('error'))
                        <div class="alert alert-danger  alert-dismissible">
                            <strong>{{ $error }}</strong>
                        </div>
                    @endif
                    @if(empty($message))
                        <form method="POST" action="{{ route('signature.upload') }}">
                            @csrf
                            <input type="hidden" name="project_id" value="{{$project_id}}">
                            <input type="hidden" name="certificate_number" value="{{$certificate_number}}">
                            <input type="hidden" name="scholar_id" value="{{$scholar_id}}">
                            @if(!empty($scholar->signature))
                                <div class="col-md-12" style="padding: 0">
                                    <h5 style="text-align: center; color: #AD0132; font-family: Montserrat, Helvetica, Arial, serif;">Click/Tap on signature to select</h5>
                                    <input type="checkbox" name="old_signature" value="{{$scholar->signature}}" id="myCheckbox1"/>
                                    <label for="myCheckbox1" class="myCheckbox1"><img src="{{$scholar->signature}}"></label>
                                    <h5 style="margin-bottom: 20px; text-align: center; color: #AD0132; font-family: Montserrat, Helvetica, Arial, serif;">OR...</h5>
                                </div>
                            @endif
                            <h4 class="card-title fw-bold mb-1" style="font-size: 1.285rem; font-weight: 500 !important; margin-bottom: 1rem !important; font-family: Montserrat, Helvetica, Arial, serif; line-height: 1.2; color: #5e5873;">Signature Pad</h4>
                            <div class="col-md-12" style="padding: 0">
                                <div id="sig"></div>
                                <br/>
                                <button id="clear" class="btn btn-secondary btn-sm"
                                        style="font-weight: 500 !important; font-family: Montserrat, Helvetica, Arial, serif;">
                                    Clear Signature
                                </button>
                                <textarea id="signature64" name="signed" style="display: none"></textarea>
                            </div>
                            <br/>
                            <button class="btn btn-primary w-100" tabindex="4"
                                    style="font-weight: 500 !important; font-family: Montserrat, Helvetica, Arial, serif; margin-bottom: 5px">
                                Save
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/scripts/jquery.signature.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
@endsection

@section('page-script')
    <script type="text/javascript">
        var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
        $('#clear').click(function (e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });

        $('div.first').click(function(event) {
            $n = event.target.nodeName;
            let $b2;
            if ($n != 'INPUT') {
                $b2 = !$('#cbx').prop("checked");
                $('#cbx').prop("checked", $b2);
            }
        })
    </script>
@endsection

