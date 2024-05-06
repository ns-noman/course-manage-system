<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans|Pinyon+Script|Rochester');
    .cursive {
        font-family: 'Pinyon Script', cursive;
    }
    .sans {
        font-family: 'Open Sans', sans-serif;
    }
    .bold {
        font-weight: bold;
    }
    body {
        padding: 20px 0;
        background: #ccc;
    }
    .block {
    display: block;
    }
    .underline {
        border-bottom: 1px solid #777;
        padding: 5px;
        margin-bottom: 15px;
    }
    .margin-0 {
        margin: 0;
    }

    .padding-0 {
        padding: 0;
    }

    .pm-empty-space {
        height: 5px;
        width: 100%;
    }

    .pm-certificate-container {
        position: relative;
        width: 800px;
        height: 600px;
        background-color: white;
        padding: 30px;
        color: black;
        font-family: 'Open Sans', sans-serif;
        box-shadow: 0 0 5px rgba(0, 0, 0, .5);
        margin: auto;

        .outer-border {
            width: 794px;
            height: 594px;
            position: absolute;
            left: 50%;
            margin-left: -397px;
            top: 50%;
            margin-top: -297px;
            border: 2px solid #fff;
        }

        .inner-border {
            width: 730px;
            height: 530px;
            position: absolute;
            left: 50%;
            margin-left: -365px;
            top: 50%;
            margin-top: -265px;
            border: 2px solid #fff;
        }

        .pm-certificate-border {
            position: relative;
            width: 720px;
            height: 520px;
            padding: 0;
            border: 1px solid #E1E5F0;
            background-color: rgba(255, 255, 255, 1);
            background-image: none;
            left: 50%;
            margin-left: -360px;
            top: 50%;
            margin-top: -260px;
            .pm-certificate-block {
                width: 650px;
                height: 200px;
                position: relative;
                left: 50%;
                margin-left: -325px;
                top: 20px;
                margin-top: 0;
            }
            .pm-certificate-header {
                margin-bottom: 10px;
            }
            .pm-certificate-title {
                position: relative;
                top: 40px;
                h2 {
                    font-size: 34px !important;
                }
            }
            .pm-certificate-body {
                padding: 20px;
                .pm-name-text {
                    font-size: 20px;
                }
            }
            .pm-earned {
                margin: 15px 0 20px;
                .pm-earned-text {
                    font-size: 20px;
                }

                .pm-credits-text {
                    font-size: 15px;
                }
            }
            .pm-course-title {
                .pm-earned-text {
                    font-size: 20px;
                }
                .pm-credits-text {
                    font-size: 15px;
                }
            }
            .pm-certified {
                font-size: 12px;
                .underline {
                    margin-bottom: 1px;
                }
            }
            .pm-certificate-footer {
                width: 650px;
                height: 100px;
                position: relative;
                left: 50%;
                margin-left: -325px;
                margin-top: 20px;
                /* bottom: -105px; */
            }
        }
    }






        /* .center {
            margin: auto;
            width: 60%;
            margin-top: 85px;
            text-align: center;
        } */

        .srl-no {
            margin: 83px 0px 0px 130px;
            width: 100%;
            font-size: 20px;
        }

        .name {
            margin: auto;
            width: 60%;
            margin-top: 180px;
            margin-left: 100px;
            text-align: center;
            font-size: 32px;
        }

        .course {
            margin: auto;
            /* width: 60%; */
            margin-top: 70px;
            margin-left: -100px;
            text-align: center;
            font-size: 32px;
        }

        .date {
            margin: auto;
            width: 60%;
            margin-top: 45px;
            text-align: right;
            font-size: 11px;
            margin-right: 155px;
            font-weight: bold;
        }

        .bg-imag {
            background: url('{{ asset('public/uploads/certificate/participation.jpg') }}');
            background-size: 800px 600px;
            background-repeat: no-repeat;
        }


</style>

<body>
    @if ($data['print_type'] == 1 || $data['print_type'] == 2)
        <div class="pm-certificate-container {{ $data['print_type'] == 2 ? 'bg-imag' : null }}">
            <div class="srl-no">
                <p><strong>
                    &nbsp;
                    {{-- {{ $data['srl_no'] }} --}}
                </strong></p>
            </div>
            <div class="name cursive">
                <p><strong>{{ $data['trainee_name'] }}</strong></p>
            </div>
            <div class="course cursive">
                <p><strong>{{ $data['course_title'] }}. {{ isset($data['remarks'])? ' Comment: ' . $data['remarks']: '' }} {{ isset($data['marks'])? ' Obtain Marks: ' . $data['marks']: '' }}</strong></p>
            </div>
            <div class="date">
                <p>
                    {{ $data['start_date'] }} to {{ $data['end_date'] }}
                </p>
            </div>
        </div>
    @else
        <div class="container pm-certificate-container">
            <div class="pm-certificate-border col-sm-12">
                <div class="row pm-certificate-header">
                    <div class="pm-certificate-title col-sm-12 text-center">
                        <h2>Sys Dev Ltd</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 text-center" style="margin-top: 10px"> 
                        <p><strong>
                            {{-- SI No- {{ $data['srl_no'] }} --}}
                        </strong></p>
                    </div>
                    <div class="cursive col-sm-6 text-center" style="margin-top: 20px"> 
                        <h2>Certificate of Participated</h2>
                    </div>
                </div>
                <div class="row pm-certificate-body" style="margin-top: 0px">
                    <div class="pm-certificate-block">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="cursive pm-course-title underline col-sm-8 text-center">
                                    <span class="block bold"><h3>{{ $data['trainee_name'] }}</h3></span>
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="pm-earned col-sm-8 text-center">
                                    <span class="block bold sans" style="font-size:20px;">Has Successfully Participated</span>
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-12"></div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="cursive pm-course-title underline col-sm-8 text-center">
                                    <span class="block bold" style="font-size:20px;">{{ $data['course_title'] }}. {{ isset($data['remarks'])? ' Comment: ' . $data['remarks']: '' }} {{ isset($data['marks'])? ' Obtain Marks: ' . $data['marks']: '' }}</span>
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-5">
                        <div class="row pm-certificate-footer">
                            <div class="col-sm-4 pm-certified text-center">
                                <span class="pm-credits-text block sans"></span>
                                <span class="pm-empty-space block underline mt-3"></span>
                                <span class="bold block">Directior/CEO</span>
                            </div>
                            <div class="col-sm-4 pm-certified text-center">
                                <span class="pm-credits-text block sans"></span>
                                <span class="pm-empty-space block underline mt-3"></span>
                                <span class="bold block">Instructor</span>
                            </div>
                            <div class="col-sm-4 pm-certified text-center">
                                <span class="pm-credits-text block sans">
                                    {{ $data['start_date'] }} to {{ $data['end_date'] }}
                                </span>
                                <span class="pm-empty-space block underline"></span>
                                <span class="bold block">Date</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</body>
