<html>

<head>

    <meta charset="utf-8">
    <title>Search Certificates | Shariyah</title>
    <meta name="keywords" content="Shariyah Certificates"/>
    <meta name="description" content="Shariyah Certificates">
    <meta name="author" content="ThemeREX">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet'
          type='text/css'>

    <link rel="stylesheet" type="text/css" href="/css/theme.css">

    <link rel="stylesheet" type="text/css" href="/css/forms.css">


    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        body {
            margin: 0px;
            padding: 0px;
            min-height: 21px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff !important;
        }

        .clear {
            clear: both;
        }
    </style>

</head>
<body class="utility-page sb-l-c sb-r-c">

<div id="main1" class="animated fadeIn">

    <section id="content_wrapper">

        <section id="content" style="padding:0 ;">

            <div class="allcp-form theme-primary mw500" id="login" style="margin-top:0;">
                <div class="clear"></div>
                <div class="text-center mb20"><h3 style="color:#333333; margin:0px; padding:0px 0px 20px 0px">
                        &nbsp; </h3></div>
                <div class="panel mw500" style="box-shadow:none;">
                    <div style="padding-left:10px; font-weight:900;">SEARCH CERTIFICATE</div>
                    <form method="post" action="/search-certificate" name="frmSubmit" id="frmSubmit">
                        @csrf
                        <div class="panel-body pn mv10">
                            <div class="section">
                                <label for="username" class="field">
                                    <input type="text" name="search" class="gui-input" id="search_certificate"
                                           placeholder="Enter certificate number" value="">
                                    <label for="username" class="field-icon">
                                    </label>
                                </label>
                            </div>


                            <div class="section">
                                <button type="submit" id="search_btn1" class="btn btn-bordered btn-primary pull-right"
                                        style="background-color:#AC1D37">Search
                                </button>
                            </div>

                        </div>

                    </form>
                </div>

            </div>

        </section>

    </section>
</div>
<style>
    * {
        box-sizing: content-box;
    }

    .certicate_detail td {
        width: 200px;
        text-align: center;
        font-size: 14px;
    }
</style>
</body>
</html>
