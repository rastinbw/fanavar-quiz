@extends('layouts.app')

@push('style')
    <style>
        .m_container {
            /* display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                height: 100%;
                margin: 0px; */

            text-align: center;
            margin: 0px;
            padding-top: 20px;

        }

        .result_container {
            width: 50%;
            border: 2px solid #000;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 30px;
            padding: 20px;
        }

        .not_result_container {
            width: 50%;
            height: 200px;
            border: 2px solid #000;
            border-radius: 10px;
            display: inline-block;
            margin-top: 20px;
            padding: 20px;
            text-align: center;
        }

        .content {
            font-size: 20px;
            direction: rtl;
        }

        .title {
            font-size: 25px;
            color: darkred;
        }

        .content label {
            color: darkred;
        }

        .carousel-inner {
            text-align: center;
        }

        .item {
            text-align: center;
        }

        #myCarousel {
            width: 60%;
            margin-left: 50px;
            margin-right: 50px;
            display: inline-block;
        }

        .item img {
            margin-left: auto;
            margin-right: auto;
        }

        .selected img {
            opacity: 0.5;
        }

        .carousel-caption {
            position: relative;
            left: auto;
            right: auto;
        }

        .carousel-control.left,
        .carousel-control.right {
            background: none;
            border: none;
        }

        .carousel-control.left {
            margin-left: -45px;
        }

        .carousel-control.right {
            margin-right: -45px;
        }

        .carousel-control {
            width: 0%;
        }

        .glyphicon-chevron-left,
        .glyphicon-chevron-right {
            color: grey;
            font-size: 40px;
        }


        .carousel-control.left {
            margin-left: -25px;
        }

        .carousel-control.right {
            margin-right: -25px;
        }

    </style>
@endpush

@section('content')
    <?php  use App\Includes\Constant;  ?>

    <div class="m_container">
        @if (isset($raven_result))
            <div class="result_container">
                <p class="title">نتیجه آخرین آزمون ریون برگزار شده به شرح زیر میباشد</p>
                <br>
                <p class="content"><label>زمان شروع آزمون: </label> {{ $raven_result['start'] }}</p>
                <p class="content"><label>زمان پایان آزمون: </label> {{ $raven_result['finish'] }}</p>
                <p class="content"><label>سن انتخاب شده: </label> {{ $raven_result['age'] }}</p>
                <p class="content"><label>دسته بندی هوش: </label> {{ $raven_result['level'] }}</p>
                <p class="content"><label>امتیاز: </label> {{ $raven_result['score'] }}</p>
            </div>
        @else
            <div class="not_result_container">
                <p class="title">شما آزمون ریون را اجرا نکرده اید</p>
            </div>
        @endif

        @if (isset($mdq_result))
            <div class="result_container">
                <p class="title">نتیجه تکمیل پرسشنامه اختلال یادگیری (ریاضی) به شرح زیر میباشد</p>
                <br>
                <p class="content"><label>زمان تکمیل پرسشنامه: </label> {{ $mdq_result['finish'] }}</p>
                <p class="content"><label>رده سنی انتخاب شده: </label> {{ Constant::$MD_LEVELS_TEXT[$mdq_result['level']] }}</p>

                @if(!empty($mdq_result['exercises']))
                    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                        <div class="carousel-inner" role="listbox">
                            <img src="ll" alt="">
                            @foreach ($mdq_result['exercises'] as $index => $item)
                                <div class="item {{ $index == 0 ? 'active' : '' }}">
                                    <p>.این تمرین مرتبط با پرسش های {{ implode(' و ', $item['numbers']) }} میباشد</p>
                                    <img class="img-exercise" src="{{ asset('storage' . $item['image']) }}" alt="not found">
                                    <p class="content">{{ $item['content'] }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                @else
                    <div class="content">
                        <p>شما دچار اختلال یادگیری (ریاضی) نمی باشید</p>
                    </div>
                @endif

            </div>

           
        @else
            <div class="not_result_container">
                <p class="title">پرسشنامه اختلال یادگیری (ریاضی) را تکمیل نکرده اید</p>
            </div>
        @endif

    </div>


@endsection
