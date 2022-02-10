@extends('layouts.app')

@push('style')
    <style>
        .m_container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100%;
            margin: 0px;

        }

        .result-box {
            border: 1px solid #000;
            padding: 10px;
            width: 30%;
            text-align: center;
            border-radius: 10px;
            display: inline-block;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .btn-home {
            display: inline-block;
            width: 30%;
            margin-top: 20px;
        }

        .img-exercise {
            width: 500px;
            height: 250px;
            ;
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
            border: 5px solid #AFAFAF;
            border-radius: 15px;
            padding: 10px;
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

        .content {
            text-align: center;
            display: inline-block;
            width: 50%;
        }
        
    </style>
@endpush

@section('content')
    <div class="m_container">

        @if (isset($result) && !empty($result))
            <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner" role="listbox">
                    <img src="ll" alt="">
                    @foreach ($result as $index => $item)
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
            <div class="result-box">
                <p>نتیجه یافت نشد</p>
            </div>
        @endif

        <a href="{{ route('quiz-list') }}" class="btn btn-primary btn-home" type="submit">بازگشت</a>

    </div>

@endsection

@push('child-scripts')

@endpush
