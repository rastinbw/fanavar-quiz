@extends('layouts.app')

@push('style')
    <style>
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-top: 15%;
        }
     
        .btn-quiz {
            display: inline-block;
            width: 30%;
            margin-top: 20px;
        }
    </style>
@endpush

@section('content')
    @php
    use Illuminate\Support\Facades\Auth;
    use App\Includes\Constant;
    @endphp

    <div class="container">
        @foreach ($quizzes as $quiz)
            @switch($quiz['name'])
                @case(Constant::$RAVEN_QUIZ)
                    <a href={{ route('ageinput', ['quiz' => $quiz['name']]) }} class="btn btn-primary btn-quiz">
                        {{ $quiz['title'] }}
                    </a>
                @break
                @case(Constant::$MD_QUESTIONNAIRE_QUIZ)
                    <a href={{ route('ageinput', ['quiz' => $quiz['name']]) }} class="btn btn-primary btn-quiz">
                        {{ $quiz['title'] }}
                    </a>
                @break
            @endswitch
        @endforeach
    </div>


    {{-- <ul>
        @foreach ($quizzes as $quiz)
            @switch($quiz['name'])
                @case(Constant::$RAVEN_QUIZ)
                    <li><a href={{ route('ageinput', ['quiz' => $quiz['name']]) }}>{{ $quiz['title'] }}</a></li>
                @break
            @break
        @endswitch
        @endforeach
    </ul> --}}
@endsection
