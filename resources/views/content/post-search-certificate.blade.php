<html>

<head>
    <title>Certificate Details | Shariyah</title>
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <style>
        body {
            margin: 0px;
            padding: 0px;
            min-height: 21px;
            background: rgba(0, 0, 0, 0) url("https://shariyah.com/ccp/assets/images/IMG_6058.jpg") no-repeat scroll 0% 0% / cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .fnt-family {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333333;
            padding-top: 6px;
            background-color: #fff;
            width: 800px;
            margin: 15px auto 10px auto;
            padding: 5px 20px 20px 20px;
        }

        .fnt-family a {
            text-decoration: none;
            color: #AC1D37;
        }

        .download_link {
            text-decoration: none;
            color: #AC1D37
        }

        .fnt-family h2 {
            font-weight: 400;
            line-height: 1.2;
            color: #2a2f43;
            text-rendering: optimizelegibility;
        }

        .back_btn {
            background-color: #AC1D37;
            color: #ffffff !important;
            margin-bottom: 0;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            border: 0;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            padding: 10px 25px;
            text-transform: uppercase;
            text-decoration: none;
            border-radius: 3px;
        }

        td strong {
            font-weight: 600;
            font-size: 13px;
            color: #333333;
        }

        td {
            font-weight: 600;
            font-size: 13px;
            font-weight: 100;
            color: #333333;
            min-width: 200px;
        }

        .not-found {
            line-height: 200px;
            text-align: center;
            color: #AC1D37;
        }

        .fnt-family tr {
            min-height: 23px;
        }

        .logo {
            text-align: center;
            padding-top: 50px;
        }
    </style>
</head>

<body>

<div class='fnt-family'><h2 style='margin-bottom:0; padding-bottom:0; font-size:24px; color:#333333'>Certificate
        Details</h2>
    <table style="width: 100%">
        <tr>
            <td colspan='2'>
                <hr>
            </td>
        </tr>
        <tr style='border-bottom:1px solid #cccccc;'>
            <td><strong>UID Code</strong></td>
            <td> {{$project->certificate_number}}</td>
        </tr>
        <tr>
            <td colspan='2' style='border-bottom:1px solid #c4c4c4;'></td>
        </tr>
        <tr>
            <td><strong>{{$subject}}</strong></td>
            <td>{{$subject_value}}</td>
        </tr>
        <tr>
            <td colspan='2' style='border-bottom:1px solid #c4c4c4;'></td>
        </tr>
        <tr>
            <td><strong>{{$status}}</strong></td>
            <td> {{$status_value}}</td>
        </tr>
        <tr>
            <td colspan='2' style='border-bottom:1px solid #c4c4c4;'></td>
        </tr>
        <tr>
            <td><strong>{{$letter}}</strong></td>
            <td><a target='_blank' href='{{$letter_value}}'>{{$letter_text}}</a></td>
        </tr>
        <tr>
            <td colspan='2' style='border-bottom:1px solid #c4c4c4;'></td>
        </tr>
        <tr>
            <td><strong>Remarks</strong></td>
            <td>{!! $project->remarks_1 !!}</td>
        </tr>
        @if(!empty($project->documents))
            <tr>
                <td colspan='2' style='border-bottom:1px solid #c4c4c4;'></td>
            </tr>
            <tr>
                <td><strong>Document(s) Reviewed</strong></td>
                <td>{{ $project->documents }}</td>
            </tr>
            <tr>
                <td colspan='2' style='border-bottom:1px solid #c4c4c4;'></td>
            </tr>
            <tr>
                <td colspan='2' style=''> &nbsp;</td>
            </tr>
        @else
            <tr>
                <td colspan='2' style='border-bottom:1px solid #c4c4c4;'></td>
            </tr>
            <tr>
                <td colspan='2' style=''> &nbsp;</td>
            </tr>
        @endif
        <tr>
            <td></td>
            <td style="text-align: left"><a class='back_btn' href='/search-certificate'>Back</a></td>
        </tr>
    </table>
</div>
</body>

</html>
