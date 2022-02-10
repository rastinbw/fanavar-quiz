@extends('layouts.app')

@push('style')
    <style>
        .carousel-inner {
            text-align: center;
        }

        .item {
            text-align: center;
        }

        #myCarousel {
            margin-left: 50px;
            margin-right: 50px;
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

        /* .options {
                                                display: flex;
                                                justify-content: space-between;
                                            } */

        .btn-submit {
            margin-top: 20px;
            width: 15em;
        }

        .option {
            margin: 5px;
            display: inline;
        }

        #timer {
            text-align: center;
            padding: 5px;
            background: #d87777;
            border: 1px solid #851e1e;
            border-radius: 5px;
            color: white;
            display: inline-block;
            width: 20%;
            direction: rtl;
        }

        .timer-container {
            margin-top: 10px;
            text-align: center
        }

        .lb-option {
            font-size: 1.5em;
        }

    </style>
@endpush

@section('content')
    @php
    use App\Includes\Constant;
    use Illuminate\Support\Facades\Session;
    @endphp

    @if (Session::has('result'))
        <script>
            console.log("we have result");
            window.location = "/fanavar-quiz/public/playground/raven/result/display";
        </script>
    @endif

    <div class="container">
        <div class="timer-container">
            <p id="timer"></p>
        </div>

        <?php
            $active_slide_index = Session::has('user_current_slide') ? Session::get('user_current_slide') : 1;
            $current_answers = Session::has('user_raven_answers') ? Session::get('user_raven_answers') : [];
        ?>

        <br>
        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
            <!-- Wrapper for slides -->
            <form dir="rtl" class="carousel-inner" role="listbox" id="quiz-form" method="POST"
                action="{{ route('raven-result-calculate') }}">
                @csrf
                @foreach ($items as $index => $item)
                    <div class="item {{ $index + 1 == $active_slide_index ? 'active' : '' }}">
                        <?php $number = $index + 1; ?>

                        <p>سوال شماره {{ $number }}</p>
                        <img src="{{ asset('storage' . $item->qo_image) }}" alt="not-found">
                        <hr>

                        <fieldset class="options" name="q-{{ $number }}" id="q-{{ $number }} ">
                            @for ($j=0; $j < $item->option_count; $j++)
                                <div class="option">
                                    <input {{ $current_answers[$number] == $j+1 ? 'checked' : '' }} name="{{ $number }}"
                                        id="{{ $number }}-r{{$j+1}}" type="radio" value="{{$j+1}}"> <label class="lb-option"
                                        for="{{ $number }}-r{{$j+1}}">گزینه {{ $j+1 }}</label>
                                </div>
                            @endfor
                            {{-- <div class="option">
                                <input {{ $current_answers[$number] == 1 ? 'checked' : '' }} name="{{ $number }}"
                                    id="{{ $number }}-r1" type="radio" value="1"> <label class="lb-option"
                                    for="{{ $number }}-r1">گزینه 1</label>
                            </div> --}}


                        </fieldset>
                    </div>
                @endforeach

                <button class="btn btn-primary btn-submit" type="submit">ثبت پاسخ</button>

            </form>

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
    </div>

@endsection

@push('child-scripts')
    <script>
        for ($i = 1; $i <= 60; $i++) {
            $('input:radio[name="' + $i + '"]').change(function() {
                //current_answers[$(this).attr('name')] = $(this).val();
                number_val = $(this).attr('name');
                selected_option_val = $(this).val();

                console.log(number_val + ": " + selected_option_val);

                $('.carousel-control.right').click()

                $.ajax({
                    method: 'GET',
                    url: '/fanavar-quiz/public/session/set/user/raven/answers?number=' + number_val +
                        '&selected_option=' + selected_option_val,
                    data: {},
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });

            });
        }


        $('#myCarousel').on('slid.bs.carousel', function() {
            currentIndex = $('div.active').index();
            $.ajax({
                method: 'GET',
                url: '/fanavar-quiz/public/session/set/user/raven/slide/current?user_current_slide=' + currentIndex,
                data: {},
                success: function(response) {
                    console.log(response);
                },
                error: function(e) {
                    console.log(e);
                }
            });

        });

        function forgetRemainingSeconds() {
            $.ajax({
                method: 'GET',
                url: '/fanavar-quiz/public/session/forget/remainingseconds',
                data: {},
                success: function(response) {
                    console.log(response);
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }


        var current_seconds =
            {!! Session::has('remaining_seconds') ? Session::get('remaining_seconds') : Constant::$TIME_LIMIT_QUIZ_RAVEN * 60 !!};
        // Set the date we're counting down to
        var countDownDate = new Date();
        countDownDate.setSeconds(countDownDate.getSeconds() + current_seconds);

        // Update the count down every 1 second
        var x = setInterval(function() {
            current_seconds = current_seconds - 1;
            $.ajax({
                method: 'GET',
                url: '/fanavar-quiz/public/session/set/remainingseconds?seconds=' + current_seconds,
                data: {},
                success: function(response) {
                    console.log(response);
                },
                error: function(e) {
                    console.log(e);
                }
            });
            // forgetRemainingSeconds();

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("timer").innerHTML = minutes + " دقیقه" + " " + seconds + " ثانیه";

            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("quiz-form").submit();
            }
        }, 1000);
    </script>

@endpush
