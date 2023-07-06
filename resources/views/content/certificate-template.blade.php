<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Certificate - Shariyah</title>
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container-fluid" style="background-color: white;">
        <div class="row" style="padding: 0">
            <div class="col-xs-2" style="width: 20%; padding: 0 10px">
                <div style="background-color: #e3e5e6; padding: 3.5px 5px;">
                    <h4 style="font-weight:bold; font-size: 14px; color: black; margin-bottom: 5px">UID CODE: {{$data['number']}}</h4>
                    <span style="font-size: 10px; text-align: justify; color: black">The authenticity of this document and list of documents approved can be verified at <br> <a
                            href="https://shariyah.net/verify-your-certificate/">https://shariyah.net/verify-your-certificate/</a></span>
                </div>
                <p style="text-align: justify; margin-top: 54px; font-size: 8px; width: 65%; color: grey">Only the mentioned product has been approved. Proper
                    implementation is the sole responsibility of the client.</p>
                <hr style="width: 65%; margin-left:0; margin-right: auto; color: black; margin-top: 10px">
                <p style="color:#AD0132; text-align: justify; font-size: 8px; width: 65%;">Attention is drawn to the limitations, indemnifications
                    and jurisdictional issues established in the disclaimer of this document
                    <br><br>
                    Any unauthorized alteration, forgery or the falsification of the content or the appearance of this
                    document is considered unlawful, and offenders may be persecuted to the fullest extent of the law
                </p>
                <hr style="width: 65%; margin-left:0; margin-right: auto; color: black; margin-top: 10px">
                <p style="text-align: justify; font-size: 8px; width: 65%; color: grey">Independent Scholar is not a member of the Sharia Board or Committee and
                    does not have professional responsibility for the ongoing Sharia supervision of the instrument
                    mentioned herein.</p>
                <p style="text-align: justify; font-size: 8px; width: 65%; color: grey">External scholar is not a member of SRB’s network of scholars and has
                    been assigned directly by the Client</p>
                <div style="margin-left: 30px; display: block; width: 115px; margin-top: 25px">
                    <img src="{{env('APP_URL_SITE')}}/images/image4.png">
                </div>
                <p style="margin-top:80px; margin-left: 65px; font-size: 10px">Page 1 of 5</p>
            </div>
            <div class="col-xs-8" style="width: 62.3%; padding: 0 10px">
                <img style="margin-top: 1px" src="{{env('APP_URL_SITE')}}/images/image9.png">
                <hr style="margin-top: 10px; margin-bottom: 0">
                <div class="row" style="padding: 0">
                    <div class="col-xs-6" style="width: 48.2%; padding: 0; padding-left: 15px">
                        <h3 style="font-size: 24px; color:#AD0132; margin-bottom: 10px; margin-top: 10px">OPINION ON SHARIA COMPLIANCE</h3>
                        <div style="border-left: 1px solid #E7A7B3; border-top: 1px solid #E7A7B3; padding: 5px 10px">
                            <h5 style="font-weight:bold; color: black; font-size: 13px; margin-top: 10px">Introduction:</h5>
                            <p style="text-align: justify; color: black; font-size: 12px">
                                We, the undersigned, have issued this opinion for <strong style="font-weight:bold;">{{$data['project']->company->name}} (the
                                    "Company")</strong> in relation to the <strong style="font-weight:bold;">{{$data['project']->product}} (the
                                    "Product")</strong>. We have been engaged to supervise only the Product in
                                connection with the engagement agreement between Shariyah Review Bureau (“SRB”) and the
                                Company, therefore, the opinion contained in this document may be relied upon only by
                                the Company (in accordance with our terms of engagement) and may be used only in
                                connection with the Product. The provision of this opinion is not to be taken as
                                implying that we owe any duty of care to anyone in relation to Sharia compliance of the
                                Product. Additionally, the provision of this opinion does not create or give rise to any
                                client relationship between us and the investors.
                            </p>
                            <p style="text-align: justify; color: black; font-size: 12px">
                                Our opinion contained herein sets out as at today’s date certain matters of Sharia
                                compliance as adopted and interpreted by us, and defined for the purposes of this
                                opinion (in no particular order) as follows:
                            </p>
                            <ul style="text-align: justify; color: black; font-size: 12px; padding-left: 12px">
                                <li>Sharia standards issued by AAOIFI;</li>
                                <li>Regulatory Sharia requirements (if any) issued by the regulator;</li>
                                <li>Sharia rulings of the Central Sharia Committee (if any);</li>
                                <li>Sharia rulings of Islamic financial institutions Sharia Supervisory Committees and;</li>
                                <li>Other specifications of Sharia compliance deemed appropriate by us the above being the
                                    "Sharia Guidelines".</li>
                            </ul>
                            <p style="text-align: justify; color: black; font-size: 12px">
                                Our opinion contained herein expresses no advice on Sharia law as it affects or would be
                                applied in any jurisdiction.
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-6" style="width: 48.2%; font-family: KFGQPC Uthman Taha Naskh, serif; padding: 0; padding-right: 15px">
                        <h3 style="font-size: 24px; direction: rtl; color:#AD0132; margin-bottom: 10px; margin-top: 10px">الرأي حول التوافق الشرعي</h3>
                        <div style="border-top: 1px solid #E7A7B3; padding: 5px 10px;">
                            <h5 style="font-weight:bold; color: black; direction: rtl; font-size: 13px; margin-top: 10px">المقدمة:</h5>
                            <p style="color: black; direction: rtl; text-align: justify; font-size: 12px">
                                يعد هذا المستند رأيا خاصا لـ<strong style="font-weight: bold"> {{$data['project']->product_ar}} ("المنتج")</strong> المقدم من <strong style="font-weight: bold"> {{$data['project']->company->name_ar}} ("الشركة")</strong> ، حيث تم تعييننا نحن الموقعون عليه من قبل شركة دار المراجعة الشرعية ("الدار") بحسب اتفاقية الارتباط بين الدار والمؤسسة للإشراف على عمليات المنتج ومراقبتها، وعليه يقتصر هذا الرأي على الجزئيات الخاصة بالمنتج وعملياته ويختص بالمؤسسة فقط وفقًا لشروط العقد ما بين الدار والمؤسسة ولا يمكن استخدامه في غير ذلك، كما لا ينشئ هذا الرأي أية علاقة تعاقدية لنا مع المستثمرين المحتملين ولا يعد من مسؤوليتنا تقديم أي تفاصيل لأي جهة بخصوص المراجعة المنفذة أو تقديم أي تفسيرات تتعلق بتوافق المنتج مع الضوابط والمعايير الشرعية.
                            </p>
                            <br><br><br><br>
                            <p style="color: black; direction: rtl; text-align: justify; font-size: 12px">
                                هذا الرأي كما تم تفسيره والموافقة عليه من قبلنا -وبالتاريخ الذي صدر فيه- يختص بالقضايا
                                المتعلقة بالتوافق الشرعي في ضوء التالي (دون ترتيب معين):
                            </p>
                            <br><br>
                            <ul style="color: black; direction: rtl; text-align: justify; font-size: 12px; padding-right: 12px">
                                <li>المعايير الشرعية الصادرة عن الأيوفي.</li>
                                <li>المتطلبات الشرعية النظامية الصادرة عن الجهات الرقابية (إن وجدت).</li>
                                <li>الأحكام الشرعية الصادرة عن اللجنة الشرعية المركزية (إن وجدت).</li>
                                <li>الأحكام الشرعية الصادرة عن اللجنة الشرعية الخاصة بالمؤسسة المالية الإسلامية.</li>
                                <li>أي مواصفات أخرى تختص بالتوافق الشرعي التي نراها مناسبة، سيشار فيما بعد لما ورد أعلاه بـ"الضوابط الشرعية".</li>
                            </ul>
                            <br>
                            <p style="color: black; direction: rtl; text-align: justify; font-size: 12px">
                                تجدر الإشارة إلى أن رأينا الوارد في هذا المستند ليس ملزماً للقضاء المعني في حال وجود
                                خلاف شرعي حيال الرأي وأثره.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-2" style="width: 13%; padding: 0 10px;">
                <div style="margin: 0 auto;display: block; width: 75px;">
                <img src="{{env('APP_URL_SITE')}}/images/image5.jpeg">
                </div>
                <hr style="margin-bottom: 0; margin-top: 32px; width: 45%; color: #E7A7B3; height: 1%;">
                <hr style="width: 72%; margin-bottom: 0; margin-top: 2px; color: #E7A7B3">
                <p style="margin-top:10px; font-size: 8px; text-align: center; color: grey;">
                    Tel + 973 17215898<br>
                    P.O.Box 21051, Al Manama<br>
                    <span style="color:#AD0132">BAHRAIN</span>
                </p>
                <hr style="width: 72%; margin-bottom: 0; margin-top: 2px; color: #E7A7B3">
                <p style="margin-top:15px; font-size: 8px; text-align: center; color: grey;">
                    Tel + 971 544434036<br>
                    P.O.Box 124342, Dubai<br>
                    <span style="color:#AD0132">UNITED ARAB EMIRATES</span>
                </p>
                @php
                    $value = 0;
                    $flag = false;
                    $s1M = $s2M = $s3M = $s4M = '50px';
                    if(!empty($data['project']->scholars[0])) {
                        $value = 70;
                        $flag = true;
                        if (!empty($data['project']->scholars[0]->picture) && !$data['all']) {
                            $s1M = 0;
                        }
                    }
                    if(!empty($data['project']->scholars[1])) {
                        $value += 70;
                        $flag = true;
                        if (!empty($data['project']->scholars[1]->picture) && !$data['all']) {
                            $s2M = 0;
                        }
                    }
                    if(!empty($data['project']->scholars[2])) {
                        $value += 70;
                        $flag = true;
                        if (!empty($data['project']->scholars[2]->picture) && !$data['all']) {
                            $s3M = 0;
                        }
                    }
                    if(!empty($data['project']->scholars[3])) {
                        $value += 70;
                        $flag = true;
                        if (!empty($data['project']->scholars[3]->picture) && !$data['all']) {
                            $s4M = 0;
                        }
                    }
                    if ($flag) {
                        $value = 345 - $value;
                        $value .= 'px';
                    } else {
                        $value = '345px';
                    }
                @endphp
                @if(!empty($data['project']->scholars[0]))
                    @php
                        $signature = \App\Models\Signature::where('project_id', $data['project']->project_id)->where('certificate_number', $data['number'])->where('scholar_id', $data['project']->scholars[0]->id)->first();
                    @endphp
                    @if ($signature)
                        <div style="text-align:center;">
                            <img style="height: 45px; text-align:center; margin-bottom: <?php echo '-' . $s1M; ?>; padding-bottom: 5px" src="{{$signature->file}}">
                        </div>
                    @elseif(!empty($data['project']->scholars[0]->picture) && !$data['all'])
                        <div style="text-align:center;">
                            <img style="height: 45px; text-align:center;" src="{{env('APP_URL_SITE')}}/uploads/{{$data['project']->scholars[0]->picture}}">
                        </div>
                    @endif
                    <hr id="scholar_1" style="margin-bottom: 0; color: black; margin-top: <?php echo $s1M; ?>; width: 90%">
                    <p style="text-align: center; font-size: 10px; color: black">{{$data['project']->scholars[0]->name}}</p>
                @endif
                @if(!empty($data['project']->scholars[1]))
                    @php
                        $signature = \App\Models\Signature::where('project_id', $data['project']->project_id)->where('certificate_number', $data['number'])->where('scholar_id', $data['project']->scholars[1]->id)->first();
                    @endphp
                    @if ($signature)
                        <div style="text-align:center;">
                            <img style="height: 45px; text-align:center; margin-bottom: <?php echo '-' . $s2M; ?>; padding-bottom: 5px" src="{{$signature->file}}">
                        </div>
                    @elseif(!empty($data['project']->scholars[1]->picture) && !$data['all'])
                        <div style="text-align:center;">
                            <img style="height: 45px; text-align:center;" src="{{env('APP_URL_SITE')}}/uploads/{{$data['project']->scholars[1]->picture}}">
                        </div>
                    @endif
                    <hr id="scholar_2" style="margin-bottom: 0; color: black; margin-top: <?php echo $s2M; ?>; width: 90%">
                    <p style="text-align: center; font-size: 10px; color: black">{{$data['project']->scholars[1]->name}}</p>
                @endif
                @if(!empty($data['project']->scholars[2]))
                    @php
                        $signature = \App\Models\Signature::where('project_id', $data['project']->project_id)->where('certificate_number', $data['number'])->where('scholar_id', $data['project']->scholars[2]->id)->first();
                    @endphp
                    @if ($signature)
                        <div style="text-align:center;">
                            <img style="height: 45px; text-align:center; margin-bottom: <?php echo '-' . $s3M; ?>; padding-bottom: 5px" src="{{$signature->file}}">
                        </div>
                    @elseif(!empty($data['project']->scholars[2]->picture) && !$data['all'])
                        <div style="text-align:center;">
                            <img style="height: 45px; text-align:center;" src="{{env('APP_URL_SITE')}}/uploads/{{$data['project']->scholars[2]->picture}}">
                        </div>
                    @endif
                    <hr id="scholar_3" style="margin-bottom: 0; color: black; margin-top: <?php echo $s3M; ?>; width: 90%">
                    <p style="text-align: center; font-size: 10px; color: black">{{$data['project']->scholars[2]->name}}</p>
                @endif
                @if(!empty($data['project']->scholars[3]))
                    @php
                        $signature = \App\Models\Signature::where('project_id', $data['project']->project_id)->where('certificate_number', $data['number'])->where('scholar_id', $data['project']->scholars[3]->id)->first();
                    @endphp
                    @if ($signature)
                        <div style="text-align:center;">
                            <img style="height: 45px; text-align:center; margin-bottom: <?php echo '-' . $s4M; ?>; padding-bottom: 5px" src="{{$signature->file}}">
                        </div>
                    @elseif(!empty($data['project']->scholars[3]->picture) && !$data['all'])
                        <div style="text-align:center;">
                            <img style="height: 45px; text-align:center;" src="{{env('APP_URL_SITE')}}/uploads/{{$data['project']->scholars[3]->picture}}">
                        </div>
                    @endif
                    <hr id="scholar_4" style="margin-bottom: 0; color: black; margin-top: <?php echo $s4M; ?>; width: 90%">
                    <p style="text-align: center; font-size: 10px; color: black">{{$data['project']->scholars[3]->name}}</p>
                @endif
                <p style="font-size: 5px; margin: 0 auto; margin-top: <?php echo $value; ?>; text-align: center; margin-bottom: 0; width: 50%">
                    SHARIA ADVISORY LICENSED BY THE CENTRAL BANK OF BAHRAIN
                </p>
                <hr style="margin-bottom: 0; margin-top: 10px; width: 45%; color: #E7A7B3; height: 1%;">
                <hr style="width: 72%; margin-bottom: 0; margin-top: 2px; color: #E7A7B3">
                <p style="color:#AD0132; font-size: 7px; text-align: center; margin-top: 10px">
                    www.shariyah.com
                </p>
            </div>
        </div>
        <div class="page-break"></div>
        <div class="row" style="padding: 0">
            <div class="col-xs-2" style="width: 20%; padding: 0 10px">
                <div style="background-color: #e3e5e6; padding: 3.5px 5px;">
                    <h4 style="font-weight:bold; font-size: 14px; color: black; margin-bottom: 5px">UID CODE: {{$data['number']}}</h4>
                    <span style="font-size: 10px; text-align: justify; color: black">The authenticity of this document and list of documents approved can be verified at <br> <a
                            href="https://shariyah.net/verify-your-certificate/">https://shariyah.net/verify-your-certificate/</a></span>
                </div>
                <p style="text-align: justify; margin-top: 54px; font-size: 8px; width: 65%; color: grey">SRB will not be responsible or liable if information
                    material to the opinion contained in this document or the subsequent Sharia audit service is withheld
                    or concealed from SRB or wrongly represented to SRB. </p>
                <hr style="width: 65%; margin-left:0; margin-right: auto; color: black; margin-top: 10px">
                <p style="color:#AD0132; text-align: justify; font-size: 8px; width: 65%;">
                    The responsibility for prevention and detection of irregularities and fraud rests with the Company
                    through implementation and operation of adequate systems of Sharia control.
                    <br><br>
                    Due to the test nature and other inherent limitations of approvals and Sharia audit, together with
                    the inherent limitations of any internal Sharia compliance system, there is an unavoidable risk that
                    some material Sharia non-compliance, including those arising from fraud and/or error, may remain
                    undiscovered even though our examination process is properly planned and performed. Therefore, our
                    approval should not be relied upon to reveal all the non-compliance, irregularities, fraud and/or
                    errors which may exist
                </p>
                <div style="margin-left: 30px; display: block; width: 115px; margin-top: 41px">
                    <img src="{{env('APP_URL_SITE')}}/images/image4.png">
                </div>
                <p style="margin-top:80px; margin-left: 65px; font-size: 10px">Page 2 of 5</p>
            </div>
            <div class="col-xs-10" style="width: 76.1%; padding: 0 10px;">
                <div style="background-color: #e3e5e6; padding: 5px; padding-bottom: 0; height: 76px">
                    <div class="row">
                        <div class="col-xs-6" style="width: 43%; padding-left:50px; padding-top: 4.5px; padding-bottom: 5px; font-size: 9px">
                            <p style="text-align: justify; margin-top: 17px; color: dimgrey; width: 85%">Our opinion should be read in conjunction with the information entailed in the Assumptions section
                                (see page 3) which is constituted as an integral part of the opinion.</p>
                        </div>
                        <div class="col-xs-6" style="width: 43%; padding-top: 4.5px; font-size: 9px; padding-left: 25px">
                            <p style="direction: rtl; font-family: KFGQPC Uthman Taha Naskh, serif; text-align: justify; margin-top: 17px; color: dimgrey; width: 85%;">
                                يجب قراءة رأينا جنباً إلى جنب مع المعلومات الواردة في قسم الافتراضات (انظرصفحة 3) والتي تشكل جزءاً لا يتجزأ من هذا الرأي.
                            </p>
                        </div>
                    </div>
                </div>
                <hr style="margin-top: 9px; margin-bottom: 0">
                <div class="row" style="padding: 0">
                    <div class="col-xs-6" style="width: 48.5%; padding: 0 10px; padding-right: 0; padding-left: 15px">
                        <h3 style="font-size: 24px; color:#AD0132; margin-bottom: 9px; margin-top: 11px">OPINION</h3>
                        <div style="border-left: 1px solid #E7A7B3; border-top: 1px solid #E7A7B3; font-size: 12px; padding: 5px 10px; padding-top: 13px">
                            <p style="text-align: justify; color: black;">
                                Based on and subject to the foregoing, and subject to the assumptions (see page 3), we
                                have for the purposes of this opinion, reviewed the documents* presented to us as part
                                of the Product (to see list of documents reviewed refer to attachment titled ‘Product
                                Memorandum’) and are satisfied that the presented documentation conform to Sharia
                                Guidelines as adopted and approved by us.
                            </p>
                            <p style="text-align: justify; color: black">
                                This opinion does not constitute 'lifetime validation' and remains valid subject to
                                satisfactory Sharia audit conducted at least once every 12 months.
                            </p>
                            <p style="text-align: justify; color: black">
                                If, for any reason, SRB is unable to complete the Sharia audit or is unable to form or
                                not form an opinion (or if the engagement between the Company and SRB is terminated) the
                                opinion contained herein shall be automatically revoked on the date at which the Sharia
                                audit becomes due for completion and remains uncompleted.
                            </p>
                            <p style="text-align: justify; color: black">
                                Allah is the Guide to Success.<br>
                                <small>*documentation reviewed in the {{$data['languages']}} language(s).</small>
                            </p>
                            <p style="text-align: justify; color: black">
                                Shariyah Review Bureau<br>
                                {{\Carbon\Carbon::parse($data['project']->date_and_time)->format('l, jS F, Y')}}
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-6" style="width: 48.5%; font-family: KFGQPC Uthman Taha Naskh, serif; padding: 0 10px; padding-left: 0; padding-right: 15px">
                        <h3 style="font-size: 24px; direction: rtl; color:#AD0132; margin-bottom: 9px; margin-top: 11px">الرأي</h3>
                        <div style="border-top: 1px solid #E7A7B3; padding: 5px 10px; font-size: 12px; padding-top: 13px">
                            <p style="color: black; direction: rtl; text-align: justify">
                                على ضوء ما تقدم وبناءً على الافتراضات الواردة في الصفحة رقم (3)، قمنا بمراجعة المستندات التي عُرضت علينا والمبينة في المرفق "مذكرة المنتج"، وإجراء التعديلات اللازمة عليها، وفي رأينا فإن هذه المستندات تتوافق مع الضوابط الشرعية وفق تفسيرنا لها.
                            </p>
                            <br><br><br>
                            <p style="color: black; direction: rtl; text-align: justify">
                                لا تعد صلاحية هذا الرأي دائمة مدى الحياة، وبقاء صلاحيته مشروط بإجراء عمليات التدقيق الشرعي الدورية على الأقل مرة كل 12 شهراً.
                            </p>
                            <p style="color: black; direction: rtl; text-align: justify">
                                إذا لم تتمكن الدار، لأي سبب من الأسباب، من إكمال عملية التدقيق الشرعي على عمليات المنتج أو كانت غير قادرة على تكوين رأي، أو إذا تم إنهاء اتفاقية الارتباط بين الدار والمؤسسة، فإن الرأي الوارد في هذا المستند يعد ملغياً تلقائياً من التاريخ الذي يصبح فيه التدقيق الشرعي متوقفاً أو غير مكتمل.
                            </p>
                            <br>
                            <p style="color: black; direction: rtl; text-align: justify">
                                والله ولي التوفيق.<br>
                                <small>* المستندات المراجعة باللغة {{$data['languages_ar']}}.</small>
                            </p>
                            <p style="color: black; direction: rtl; text-align: justify">
                                دارالمراجعة الشرعية <br>
                                {{$data['date']}}
                            </p>
                        </div>
                    </div>
                    <div style="width: 115px; display: block; margin: 0 auto;">
                        <img src="{{env('APP_URL_SITE')}}/images/image7.png">
                    </div>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        <div class="row" style="padding: 0">
            <div class="col-xs-2" style="width: 20%; padding: 0 10px">
                <div style="background-color: #e3e5e6; padding: 3.5px 5px;">
                    <h4 style="font-weight:bold; font-size: 14px; color: black; margin-bottom: 5px">UID CODE: {{$data['number']}}</h4>
                    <span style="font-size: 10px; text-align: justify; color: black">The authenticity of this document and list of documents approved can be verified at <br> <a
                            href="https://shariyah.net/verify-your-certificate/">https://shariyah.net/verify-your-certificate/</a></span>
                </div>
                <p style="text-align: justify; margin-top: 54px; font-size: 8px; width: 65%; color: grey">Our opinion contained in this document relates only to
                    the relevant Product, transaction or activity (as the case may be) in relation to which it is issued
                    and shall not be used in relation to any other product, transaction or any other business activity
                    of the Company. Our opinion contained in this document is neither assignable or sub-licensable to
                    another product or transaction.</p>
                <hr style="width: 65%; margin-left:0; margin-right: auto; color: black; margin-top: 10px">
                <p style="color:#AD0132; text-align: justify; font-size: 8px; width: 65%;">
                    SRB shall not be, under any circumstances, liable for any information related to the Product, its
                    transaction or activity received from the Company, and it has no obligation to verify the veracity
                    or truth of such information, which has been accepted “as is”.
                </p>
                <div style="margin-left: 30px; display: block; width: 115px; margin-top: 132px">
                    <img src="{{env('APP_URL_SITE')}}/images/image4.png">
                </div>
                <p style="margin-top:80px; margin-left: 65px; font-size: 10px">Page 3 of 5</p>
            </div>
            <div class="col-xs-10" style="width: 76.1%; padding: 0 10px">
                <div style="background-color: #e3e5e6; padding: 5px; padding-bottom: 0; height: 76px">
                    <div class="row">
                        <div class="col-xs-6" style="width: 43%; padding-left:50px; padding-top: 4.5px; padding-bottom: 5px; font-size: 9px">
                            <p style="text-align: justify; margin-top: 17px; color: dimgrey; width: 85%">Our opinion should be read in conjunction with the information entailed herein. Further, this attachment is
                                constituted as an integral part of the opinion.</p>
                        </div>
                        <div class="col-xs-6" style="width: 43%; padding-top: 4.5px; font-size: 9px; padding-left: 25px">
                            <p style="direction: rtl; font-family: KFGQPC Uthman Taha Naskh, serif; text-align: justify; margin-top: 17px; color: dimgrey; width: 85%;">
                                يجب قراءة هذا الملحق بما يتض ّمنه من المعلومات
                                مع شهادة االعتماد الشرعي، حيث أ ّن المرفقات هذه تعتبر جزءا ال يتجزأ من ً
                                شهادة االعتماد الشرعي.
                            </p>
                        </div>
                    </div>
                </div>
                <hr style="margin-top: 9px; margin-bottom: 0">
                <div class="row" style="padding: 0">
                    <div class="col-xs-6" style="width: 48.5%; margin-right: 0; padding: 0 10px; padding-right: 0; padding-left: 15px">
                        <h3 style="font-size: 24px; color:#AD0132; margin-bottom: 9px; margin-top: 11px">ASSUMPTIONS</h3>
                        <div style="border-left: 1px solid #E7A7B3; border-top: 1px solid #E7A7B3; padding: 5px 10px; padding-top: 5px">
                            <h5 style="font-weight:bold; color: black; font-size: 12px; text-align: justify">Subject to the terms and conditions of our
                                engagement agreement with the Company, our opinion contained herein is dependent on the
                                following key assumptions:</h5>
                            <ul style="text-align: justify; color: black; font-size: 11.4px; padding-left: 12px">
                                <li>
                                    The Company did not fail to disclose Product information which they should have
                                    disclosed relevant for the purposes of this opinion.
                                </li>
                                <br>
                                <li>
                                    The Product documents disclosed as final copies to us has not since then been altered
                                    or added to. The Company will remain responsible to inform us promptly of any changes
                                    to the documentation or circumstances, which may materially impact the continued validity
                                    of our opinion contained herein.
                                </li>
                                <br>
                                <li>
                                    The Company will remain responsible for  establishing and maintaining an internal
                                    Sharia compliance system for the Product including, but not limited to, internal controls,
                                    policies & procedures, guidelines covering the transactional process and non-compliance
                                    containment procedures.
                                </li>
                                <br>
                                <li>
                                    We, the undersigned, have not reviewed, or audited funds, products or services
                                    certified by other Sharia scholars (“Third-Party Documents”), therefore, we cannot
                                    conform that such Third-Party Documents are Sharia compliant. We shall not be liable
                                    for any loss or damage of whatever nature (direct, indirect, consequential,
                                    reputational or other) whether arising in contract, tort or due to non-compliance of
                                    Sharia, which may arise as a result of using such Third-Party Documents. In a
                                    scenario where the Third-Party Documents are made part of the Product, our opinion
                                    of the transaction should not be taken as an endorsement of the Third-Party
                                    Documents.
                                </li>
                                <br>
                                <li>
                                    We, the undersigned, will work with SRB (where required under the engagement) to
                                    conduct the annual Sharia review (“audit”) in accordance with the AAOIFI-GSIFI No.
                                    2. The audit will be conducted through a sampling process and any statement of
                                    conformance issued by us in any form or means will be based on the outcome of this
                                    sampling process. Additionally, our ability to express an opinion after the audit,
                                    and the wording of such opinion, will be dependent on the facts and circumstances at
                                    the date of the audit report.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-6" style="width: 48.5%; font-family: KFGQPC Uthman Taha Naskh, serif; margin-left: 0; padding: 0 10px; padding-left: 0; padding-right: 15px">
                        <h3 style="direction: rtl; color:#AD0132; margin-bottom: 9px; font-size: 24px; margin-top: 11px">الافتراضات</h3>
                        <div style="border-top: 1px solid #E7A7B3; padding: 5px 10px; padding-top: 5px">
                            <h5 style="font-weight:bold; color: black; direction: rtl; font-size: 12px; text-align: justify">وفقًا لشروط وأحكام الاتفاقية مع الشركة، فإن رأينا الوارد هنا يعتمد على الافتراضات الرئيسية التالية:</h5>
                            <br>
                            <ul style="text-align: justify; color: black; direction: rtl; font-size: 12px; padding-right: 12px">
                                <li>•
                                    قدمت المؤسسة جميع المعلومات الضرورية الخاصة بالمنتج والتي من شأنها التأثير على هذا الرأي.
                                </li>
                                <br><br>
                                <li>•
                                    جميع النسخ الخاصة بالمنتج نهائية ولم يتم التعديل عليها أو الإضافة عليها من تاريخ تقديمها لنا للمراجعة، وتظل المؤسسة مسؤولة عن إبلاغنا على الفور بأي تعديلات تطرأ على الوثائق والمستندات والتي قد تؤثر بشكل جوهري على استمرارية صلاحية هذا الرأي.
                                </li>
                                <br><br>
                                <li>•
                                    ستظل المؤسسة مسؤولة عن إنشاء والإشراف على نظام رقابة داخلي للتوافق مع الضوابط والمعايير الشرعية الخاصة بالمنتج، بما في ذلك على سبيل المثال لا الحصر الضوابط والسياسات والإجراءات الداخلية، والمبادئ التوجيهية التي تغطي كل مرحلة من مراحل تنفيذ العمليات، بالإضافة إلى إجراءات احتواء أي خرق أو مخالفة للمعايير الخاصة بالمنتج.
                                </li>
                                <br>
                                <li>•
                                    لم نقم بالمراجعة أو التدقيق على الصناديق أو المنتجات أو الخدمات المعتمدة من لجان شرعية أخرى ("مستندات الطرف الثالث")، وبالتالي، لا يمكننا التأكيد على توافق هذه المستندات مع الضوابط والمعايير الشرعية، وعليه، لن نكون مسؤولين عن أي ضرر أو خسارة مهما كانت طبيعتها (مباشرة أو غير مباشرة، أو تبعية، أو متعلقة بالسمعة، أو غير ذلك) سواء كانت ناشئةً عن العقد أو بسبب عدم التوافق مع الضوابط والمعايير الشرعية، والذي قد ينشأ نتيجة استخدام مستندات الطرف الثالث، وفي حال كانت مستندات الطرف الثالث جزءاً من المنتج فلا ينبغي اعتبار رأينا بخصوص المنتج شاملًا لمستندات الطرف الثالث.
                                </li>
                                <br><br>
                                <li>•
                                    سنقوم بالعمل مع الدار (وفق الاقتضاء) لإجراء مراجعة سنوية ("التدقيق") وفقاً لمعيار الحوكمة الشرعي رقم 2 الصادر عن الأيوفي، وسيتم إجراء عملية التدقيق من خلال اختيار مجموعة من العينات، وبالتالي فإن أي بيان عن توافق عمليات المنتج مع الضوابط والمعايير الشرعية بأي شكل من الأشكال سوف يستند إلى هذه العينات المُراجعة. بالإضافة إلى ذلك ستعتمد قدرتنا على إبداء الرأي حول عمليات المنتج المنفذة على الحقائق ونتائج التدقيق حسب تاريخ تنفيذها.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        <div class="row" style="padding: 0">
            <div class="col-xs-2" style="width: 20%; padding: 0 10px">
                <div style="background-color: #e3e5e6; padding: 3.5px 5px;">
                    <h4 style="font-weight:bold; font-size: 14px; color: black; margin-bottom: 5px">UID CODE: {{$data['number']}}</h4>
                    <span style="font-size: 10px; text-align: justify; color: black">The authenticity of this document and list of documents approved can be verified at <br> <a
                            href="https://shariyah.net/verify-your-certificate/">https://shariyah.net/verify-your-certificate/</a></span>
                </div>
                @php
                    $value = '400';
                    $s5M = '85px';
                    $s6M = $s7M = $s8M = '65px';
                    if(!empty($data['project']->scholars[4])) {
                        $value -= 100;
                        if (!empty($data['project']->scholars[4]->picture) && !$data['all']) {
                            $s5M = 0;
                        }
                    }
                    if(!empty($data['project']->scholars[5])) {
                        $value -= 87;
                        if (!empty($data['project']->scholars[5]->picture) && !$data['all']) {
                            $s6M = 0;
                        }
                    }
                    if(!empty($data['project']->scholars[6])) {
                        $value -= 87;
                        if (!empty($data['project']->scholars[6]->picture) && !$data['all']) {
                            $s7M = 0;
                        }
                    }
                    if(!empty($data['project']->scholars[7])) {
                        $value -= 87;
                        if (!empty($data['project']->scholars[7]->picture) && !$data['all']) {
                            $s8M = 0;
                        }
                    }
                    $value .= 'px';
                @endphp
                @if(!empty($data['project']->scholars[4]))
                    @php
                        $signature = \App\Models\Signature::where('project_id', $data['project']->project_id)->where('certificate_number', $data['number'])->where('scholar_id', $data['project']->scholars[4]->id)->first();
                    @endphp
                    @if ($signature)
                        <div style="text-align:center;">
                            <img style="margin-top: 20px; height: 45px; text-align:center; margin-bottom: <?php echo '-' . $s5M; ?>; padding-bottom: 5px" src="{{$signature->file}}">
                        </div>
                    @elseif(!empty($data['project']->scholars[4]->picture) && !$data['all'])
                        <div style="text-align:center;">
                            <img style="margin-top: 20px; height: 45px; text-align:center;" src="{{env('APP_URL_SITE')}}/uploads/{{$data['project']->scholars[4]->picture}}">
                        </div>
                    @endif
                    <hr id="scholar_5" style="margin-bottom: 0; color: black; margin-top: <?php echo $s5M; ?>; width: 90%">
                    <p style="text-align: center; font-size: 10px; color: black">{{$data['project']->scholars[4]->name}}</p>
                @endif
                @if(!empty($data['project']->scholars[5]))
                    @php
                        $signature = \App\Models\Signature::where('project_id', $data['project']->project_id)->where('certificate_number', $data['number'])->where('scholar_id', $data['project']->scholars[5]->id)->first();
                    @endphp
                    @if ($signature)
                        <div style="text-align:center;">
                            <img style="margin-top: 10px; height: 45px; text-align:center; margin-bottom: <?php echo '-' . $s6M; ?>; padding-bottom: 5px" src="{{$signature->file}}">
                        </div>
                    @elseif(!empty($data['project']->scholars[5]->picture) && !$data['all'])
                        <div style="text-align:center;">
                            <img style="margin-top: 10px; height: 45px; text-align:center;" src="{{env('APP_URL_SITE')}}/uploads/{{$data['project']->scholars[5]->picture}}">
                        </div>
                    @endif
                    <hr id="scholar_6" style="margin-bottom: 0; color: black; margin-top: <?php echo $s6M; ?>; width: 90%">
                    <p style="text-align: center; font-size: 10px; color: black">{{$data['project']->scholars[5]->name}}</p>
                @endif
                @if(!empty($data['project']->scholars[6]))
                    @php
                        $signature = \App\Models\Signature::where('project_id', $data['project']->project_id)->where('certificate_number', $data['number'])->where('scholar_id', $data['project']->scholars[6]->id)->first();
                    @endphp
                    @if ($signature)
                        <div style="text-align:center;">
                            <img style="margin-top: 10px; height: 45px; text-align:center; margin-bottom: <?php echo '-' . $s7M; ?>; padding-bottom: 5px" src="{{$signature->file}}">
                        </div>
                    @elseif(!empty($data['project']->scholars[6]->picture) && !$data['all'])
                        <div style="text-align:center;">
                            <img style="margin-top: 10px; height: 45px; text-align:center;" src="{{env('APP_URL_SITE')}}/uploads/{{$data['project']->scholars[6]->picture}}">
                        </div>
                    @endif
                    <hr id="scholar_7" style="margin-bottom: 0; color: black; margin-top: <?php echo $s7M; ?>; width: 90%">
                    <p style="text-align: center; font-size: 10px; color: black">{{$data['project']->scholars[6]->name}}</p>
                @endif
                @if(!empty($data['project']->scholars[7]))
                    @php
                        $signature = \App\Models\Signature::where('project_id', $data['project']->project_id)->where('certificate_number', $data['number'])->where('scholar_id', $data['project']->scholars[7]->id)->first();
                    @endphp
                    @if ($signature)
                        <div style="text-align:center;">
                            <img style="margin-top: 10px; height: 45px; text-align:center; margin-bottom: <?php echo '-' . $s8M; ?>; padding-bottom: 5px" src="{{$signature->file}}">
                        </div>
                    @elseif(!empty($data['project']->scholars[7]->picture) && !$data['all'])
                        <div style="text-align:center;">
                            <img style="margin-top: 10px; height: 45px; text-align:center;" src="{{env('APP_URL_SITE')}}/uploads/{{$data['project']->scholars[7]->picture}}">
                        </div>
                    @endif
                    <hr id="scholar_8" style="margin-bottom: 0; color: black; margin-top: <?php echo $s8M; ?>; width: 90%">
                    <p style="text-align: center; font-size: 10px; color: black">{{$data['project']->scholars[7]->name}}</p>
                @endif
                <div style="margin-left: 30px; display: block; width: 115px; margin-top: <?php echo $value; ?>;">
                    <img src="{{env('APP_URL_SITE')}}/images/image4.png">
                </div>
                <p style="margin-top:78px; margin-left: 65px; font-size: 10px">Page 4 of 5</p>
            </div>
            <div class="col-xs-10" style="width: 76.1%; padding: 0 10px">
                <div style="background-color: #e3e5e6; padding: 5px; padding-bottom: 0; height: 76px">
                    <h3 style="padding-right:25px; padding-bottom: 16px; text-align: right; font-weight: bold; font-size: 14px; padding-top: 8px;">
                        Product Memorandum &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: KFGQPC Uthman Taha Naskh, serif; direction: rtl">مذكرة المنتج</span>
                    </h3>
                </div>
                <hr style="margin-top: 9px; margin-bottom: 0">
                <div class="row" style="padding: 0; margin-top: 10px; padding-left: 5px;">
                    <div class="col-xs-6" style="width: 47.7%; font-size: 12px; margin-right: 15px; padding: 0 10px; padding-right: 0; text-align: justify; padding-left: 10px;">
                        <p>
                            <span style="font-weight: bold">Product Name:</span> {{$data['project']->product}}.
                        </p>
                        <p>
                            <span style="font-weight: bold">Opinion Policy:</span> The Opinion should be read in conjunction with the information entailed on this page, as it is an integral part of the Opinion.
                        </p>
                        <p>
                            <span style="font-weight: bold">Documentation Reviewed:</span> The SSC has relied on the following source of information formulated and submitted by {{$data['project']->company->name}}:
                        </p>
                    </div>
                    <div class="col-xs-6" style="width: 48%; font-family: KFGQPC Uthman Taha Naskh, serif; direction: rtl; font-size: 12px; margin-left: 15px; padding: 0 10px; padding-left: 0; text-align: justify; padding-left: 4px;">
                        <p>
                            <span style="font-weight: bold">اسم المنتج: </span> {{$data['project']->product_ar}}.
                        </p>
                        <p>
                            <span style="font-weight: bold">سياسة الرأي: </span>يجب قراءة الرأي بما يتضمنه من المعلومات الواردة أدناه.  حيث أنها تعتبر جزءا لا يتجزء من الرأي.
                        </p>
                        <br>
                        <p>
                            <span style="font-weight: bold">المستندات المراجعة: </span>اعتمدت اللجنة الشرعية على المعلومات والمستندات المقدمة من قبل شركة {{$data['project']->company->name_ar}} :
                        </p>
                    </div>
                    <div style="margin-top: 10px; padding-left: 10px; padding-right: 15px">
                        <table class="table table-bordered" style="font-size: 10px">
                            <tbody>
                            @foreach($data['docs'] as $d => $document)
                                <tr>
                                    <td style="padding: 5px; text-align: center" colspan="2"><strong style="font-weight: bold;">{{$d}}</strong></td>
                                </tr>
                                @foreach($document as $doc)
                                    <tr>
                                        <td style="padding: 5px; text-align: left; width: 50%">{{$doc->name}}</td>
                                        <td style="padding: 5px; font-family: KFGQPC Uthman Taha Naskh, serif; direction: rtl; text-align: right; width: 50%">{{$doc->name_ar}}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(isset($data['project']->guideline_id))
                        <h3 style="padding-left:10px; margin-top: 0; font-size: 14px">The Product/Fund will be subjected to the following Shariah Guidelines:
                            <a href="{{env('APP_URL_SITE') . '/' . $data['project']->guideline->link}}">LINK</a>
                        </h3>
                    @endif
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        <div class="row" style="padding: 0">
            <div class="col-xs-6" style="width: 48%; font-size: 11px; text-align: justify; padding: 0 10px">
                <h3 style="font-weight: bold; text-decoration: underline; font-size: 14px;">
                    Disclaimer:
                </h3>
                <p>
                    This opinion is based on the review of the assigned scholar(s) and their interpretation of the
                    guiding principles of, but not limited to, AAOIFI Sharia standards, rulings of the Central Sharia
                    Committee of the respective jurisdiction, approvals and rulings given by the Sharia Supervisory
                    Committee of various Islamic financial institutions. This opinion is expressed, as of the date
                    expressed and is no statement of fact or recommendations to buy, hold, or sell any securities or
                    make any other investment decisions and neither does it address the suitability of any investment in
                    the Product.
                </p>
                <p>
                    No content of the opinion or any part thereof (“Content”) may be modified, reproduced or distributed
                    in any form by any means, or stored in a database or retrieval system, without the prior written
                    permission of Shariyah Review Bureau (“SRB”). The Content shall not be used for any unlawful or
                    unauthorized purposes. SRB and any third-party providers, as well as their directors, officers,
                    managers, shareholders, employees, partners, scholars and Advisors (collectively “SRB Parties”) do
                    not guarantee the accuracy, completeness, timeliness or availability of the information upon which
                    the Content has been based. SRB Parties are not responsible for any errors or omissions (negligent
                    or otherwise), and regardless of the cause, for the results obtained from the use of the Content.
                </p>
                <p>
                    The Content is provided on an "as is" basis. SRB parties disclaim any and all expressed or implied
                    warranties, including, but not limited to, any warranties of merchantability or fitness for a
                    particular purpose or use, or freedom from errors or defects. In no event shall SRB Parties be
                    liable to any party for any direct, indirect, incidental, exemplary, compensatory, punitive, special
                    or consequential damages, costs, expenses, legal fees, or losses (including, without limitation,
                    lost income or lost profits and opportunity costs or losses caused by negligence) in connection with
                    any use of the Content even if advised of the possibility of such damages.   
                </p>
                <p>
                    SRB assumes no obligation to update the Content following publication in any form or format. The
                    Content is not a substitute for the skill, judgment and experience of the user, management,
                    employees, advisors and/or clients when making investment and other business decisions. While SRB
                    has obtained information from sources it believes to be reliable, it undertakes no duty of due
                    diligence or independent verification of any information it receives.
                </p>
                <p>
                    To the extent that regulatory authorities allow a Shari’a Advisory firm to acknowledge in one
                    jurisdiction a Shari’a Certificate issued in another jurisdiction for certain regulatory purposes,
                    SRB reserves the right to assign, withdraw, or suspend such opinion at any time at its sole
                    discretion. SRB Parties disclaim any duty whatsoever arising out of the assignment, withdrawal, or
                    suspension of an opinion as well as any liability for any damage alleged to have been suffered on
                    account thereof.
                </p>
                <p>
                    Prospective Investors should note that different Shari’a Advisors, and Shari’a courts and judicial
                    committees, may form different opinions on identical issues and therefore prospective Investors
                    should consult their Shari’a advisers as to whether the Product will meet their individual standards
                    of compliance . Prospective Investors should also note that this opinion would not bind a court or
                    judicial committee, including in the context of any insolvency or bankruptcy proceedings.
                    Accordingly, no representation is made regarding the Shari’ah compliance of the Product.
                </p>
                <p>
                    In any and all cases, the English version of this disclaimer shall prevail over the Arabic version.
                </p>
            </div>
            <div class="col-xs-6" style="font-family: KFGQPC Uthman Taha Naskh, serif; direction: rtl; width: 48%; font-size: 11px; text-align: justify; padding: 0 10px">
                <h3 style="font-weight: bold; text-decoration: underline; font-size: 14px;">
                    اخلاء مسؤولية:
                </h3>
                <p>
                    يعتمد هذا الرأي على مراجعة المستشار/المستشارين الشرعي المعين وتفسيره للمبادئ والضوابط والتوجيهات
                    الخاصة بالمعايير الشرعية الصادرة عن هيئة المحاسبة والمراجعة للمؤسسات المالية الإسلامية ("الأيوفي")،
                    بالإضافة إلى الضوابط والمعايير الصادرة عن اللجنة الشرعية المركزية ذات الاختصاص القضائي، والأحكام
                    والضوابط والمعايير الصادرة عن الهيئات الشرعية الخاصة بالمؤسسات المالية الإسلامة وغير ذلك من المراجع
                    الشرعية، ويبدأ سريانه من تاريخ إصداره، كما أن هذا الرأي لا يعتبر توصية بشراء، أوتعاقد، أو بيع أية
                    أوراق مالية أو اتخاذ أي قرارات استثمارية أخرى في المنتج.
                </p>
                <br>
                <p>
                    لا يمكن تعديل محتوى الرأي أو أي جزء منه (”المحتوى“)، أو إعادة طباعته أو توزيعه بأي شكل من الأشكال
                    وبأية وسيلة كانت، أو تخزينه في نظام قاعدة البيانات أو استرجاعه، دون الحصول على إذن خطي مسبق من دار
                    المراجعة الشرعية (”الدار“)، ولا يجوز استخدام المحتوى لأية أغراض غير قانونية أو غير مصرح بها. كما أن
                    الدار أو أي طرف ثالث من مقدمي الخدمات، بالإضافة إلى الإدارة والمدراء والمساهمين والموظفين
                    والمستشارين (يعبر عنهم جميعاً "بشركاء الدار”) لا يضمنون دقة أو اكتمال أو توافر المعلومات التي استند
                    عليها المحتوى، كما لا يتحملون مسؤولية أي خطأ أو إغفال ("إهمالا كان أو غير ذلك”)، أو النتائج التي تم
                    الحصول عليها من استخدام المحتوى.
                </p>
                <br><br><br>
                <p>
                    تقع مسؤولية المحتوى على الجهة المرسلة، دون أي مسؤولية على الدار أو شركائها، ودون أية ضمانات تتعلق
                    بالتسويق أو الملاءمة أو الأخطاء أو العيوب، وفي جميع الأحوال لا تتحمل الدار أية مسؤولية تجاه أي طرف
                    سواء مباشرة كانت أو غير مباشرة، دائمة أو عرضية، كما لا تلتزم بأية تعويضات لأي طرف سواء أصلية كانت أو
                    تبعية، بالإضافة إلى عدم تحملها للتكاليف والنفقات والرسوم القانونية، أو الخسائر ("بما في ذلك دون حصر،
                    خسارة الأرباح وتكلفة فقدان الفرصة البديلة أو الخسائر الناجمة عن الإهمال”) فيما يتعلق بأي استخدام
                    للمحتوى حتى لو تمت الإشارة بإمكانية حدوث مثل هذه الأضرار.
                </p>
                <br><br>
                <p>
                    لا تترتب على الدار أية مسؤولية تتعلق بأي تحديث لاحق يمس المحتوى بعد تاريخ نشره بأي طريقة أو شكل، كما
                    أن المحتوى لا يعد بديلاً عن خبرة العميل وسلامة رأيه وتجربته وإدارته وموظفيه ومستشاريه أو عملائه عند
                    أخذ أية قرارت استثمارية أو تجارية. تجدر الإشارة إلى أن الدار قد حصلت على المعلومات الخاصة بالمحتوى
                    من مصادر تعتقد أنها موثوقة، ومع ذلك فالدار غير ملزمة بالتحقيق المستقل عن صحة المعلومات التي تتلقاها
                    من تلك المصادر.
                </p>
                <br>
                <p>
                    يجوز لشركات الاستشارات الشرعية–وفق النطاق المسموح به من قبل الجهات المشرفة- أن تستند على شهادات
                    شرعية صادرة في أماكن ودول غير الأماكن والدول المستخدمة فيها لأغراض تنظيمية معنية، ومع ذلك تحتفظ
                    الدار بحقها في تحويل أو سحب أو تعليق مثل هذه الآراء في أي وقت شاءت وفق تقديرها الخاص. وتخلي الدار
                    مسؤوليتها من أي أمر ناشئ عن ما تقدم كما تخلي مسؤوليتها عن أي ضرر يزعم أنه قد حصل بسبب ذلك.
                </p>
                <br><br>
                <p>
                    يجب على المستثمرين المحتملين إدراك أن اختلاف المستشارين الشرعيين، والمحاكم الشرعية واللجان القضائية،
                    يمكن أن يشكل وجهات نظر مختلفة حول المنتج المعتمد في هذا المستند، وبالتالي يجب على المستثمرون
                    المحتملين استشارة مستشاريهم الشرعيين حول ما إذا كان المنتج متوافق مع الضوابط والمعايير الشرعية
                    المعتمدة لديهم، كما يجب على المستثمرين المحتملين أن يعرفوا أيضا أنه بالرغم من أن المستشارين الشرعيين
                    قد أصدروا هذا الرأي وفق الضوابط والمعايير الشرعية، إلا أن هذه الآراء لا تلزم أي محكمة أو لجنة قضائية
                    -بما في ذلك قضايا الإعسار وإجراءات الإفلاس-، وللمحاكم الشرعية واللجان القضائية الحرية في إثبات كون
                    الوثائق والمستندات ذات الصلة (أو أي جزء منها) متوافقة مع مبادئ الشريعة الإسلامية أم لا.
                </p>
                <br>
                <p>
                    في جميع الأحوال، يعتمد النص الإنجليزي على النص العربي عند اختلاف النصين.
                </p>
            </div>
            <br>
            <p style="width:100%; text-align: center; font-size: 12px;">
                NOTE: THIS OPINION  IS VALID ONLY WITH OFFICIAL COMPANY SEAL ON THE LEFT & SHARI’A REVIEW DEP. STAMP ON THE RIGHT<br>
                <span style="font-family: KFGQPC Uthman Taha Naskh, serif; direction: rtl;">
                ملاحظة: لا يعتد بهذا الرأي إلا بوجود ختم دار المراجعة الشرعية على يساره و ختم إدارة المراجعة على يمينه
                    </span>
            </p>
        </div>
    </div>
</body>
</html>
