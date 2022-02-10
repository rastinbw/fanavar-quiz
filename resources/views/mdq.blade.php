@extends('layouts.app')

@push('style')
    <style>
        .item {
            padding: 5px;
            margin-bottom: 2px;
            margin-top: 2px;
            border: 1px solid black;
            font-size: 20px;
        }

        .option {
            margin: 5px;
            display: inline;
        }

        .form-container {
            margin-bottom: 20px;
        }

        .btn-submit {
            margin-top: 20px;
            margin-bottom: 20px;
            width: 15em;
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
            window.location = "/fanavar-quiz/public/playground/mdq/result/display";
        </script>
    @endif

    <div class="container">
        <?php
            $current_answers = Session::has('user_mdq_answers') ? Session::get('user_mdq_answers') : [];
        ?>

        <br>
        <div class="form-container">
            <form dir="rtl" id="quiz-form" method="POST" action="{{ route('mdq-result-calculate') }}">
                @csrf
                @foreach ($items as $index => $item)
                    <?php $number = $index + 1; ?>
                    <div class="item" style="{{ ($number%2==0) ? "background:#efefef" : "background:#ffffff"}}">
                        
                        <p><label style="font-weight: 300">سوال شماره {{ $number }}:</label> {{ $item->question }}</p>

                        <fieldset class="options" name="q-{{ $number }}" id="q-{{ $number }} ">

                            <div class="option">
                                <input {{ $current_answers[$number] == 1 ? 'checked' : '' }} name="{{ $number }}"
                                    id="{{ $number }}-r1" type="radio" value="1"> <label class="lb-option"
                                    for="{{ $number }}-r1">بله</label>
                            </div>

                            <div class="option">
                                <input {{ $current_answers[$number] == 0 ? 'checked' : '' }} name="{{ $number }}"
                                    id="{{ $number }}-r0" type="radio" value="0"> <label class="lb-option"
                                    for="{{ $number }}-r0">خیر</label>
                            </div>

                        </fieldset>
                    </div>
                @endforeach

                <button class="btn btn-primary btn-submit" type="submit">ثبت پاسخ</button>

            </form>
        </div>
    </div>

@endsection

@push('child-scripts')
    <script>
        count = {!! sizeof($items) !!};
        for ($i = 1; $i <= count; $i++) {
            $('input:radio[name="' + $i + '"]').change(function() {
                //current_answers[$(this).attr('name')] = $(this).val();
                number_val = $(this).attr('name');
                selected_option_val = $(this).val();

                console.log(number_val + ": " + selected_option_val);

                $.ajax({
                    method: 'GET',
                    url: '/fanavar-quiz/public/session/set/user/mdq/answers?number=' + number_val +
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


        // $('#myCarousel').on('slid.bs.carousel', function() {
        //     currentIndex = $('div.active').index();
        //     $.ajax({
        //         method: 'GET',
        //         url: '/fanavar-quiz/public/session/set/user/raven/slide/current?user_current_slide=' + currentIndex,
        //         data: {},
        //         success: function(response) {
        //             console.log(response);
        //         },
        //         error: function(e) {
        //             console.log(e);
        //         }
        //     });

        // });

        // function forgetRemainingSeconds() {
        //     $.ajax({
        //         method: 'GET',
        //         url: '/fanavar-quiz/public/session/forget/remainingseconds',
        //         data: {},
        //         success: function(response) {
        //             console.log(response);
        //         },
        //         error: function(e) {
        //             console.log(e);
        //         }
        //     });
        // }


        // var current_seconds =
        //     {!! Session::has('remaining_seconds') ? Session::get('remaining_seconds') : Constant::$TIME_LIMIT_QUIZ_RAVEN * 60 !!};
        // // Set the date we're counting down to
        // var countDownDate = new Date();
        // countDownDate.setSeconds(countDownDate.getSeconds() + current_seconds);

        // // Update the count down every 1 second
        // var x = setInterval(function() {
        //     current_seconds = current_seconds - 1;
        //     $.ajax({
        //         method: 'GET',
        //         url: '/fanavar-quiz/public/session/set/remainingseconds?seconds=' + current_seconds,
        //         data: {},
        //         success: function(response) {
        //             console.log(response);
        //         },
        //         error: function(e) {
        //             console.log(e);
        //         }
        //     });
        //     // forgetRemainingSeconds();

        //     // Get today's date and time
        //     var now = new Date().getTime();

        //     // Find the distance between now and the count down date
        //     var distance = countDownDate - now;

        //     // Time calculations for days, hours, minutes and seconds
        //     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        //     var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        //     // Output the result in an element with id="demo"
        //     document.getElementById("timer").innerHTML = minutes + " دقیقه" + " " + seconds + " ثانیه";

        //     // If the count down is over, write some text 
        //     if (distance < 0) {
        //         clearInterval(x);
        //         document.getElementById("quiz-form").submit();
        //     }
        // }, 1000);
    </script>

@endpush
