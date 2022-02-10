@extends('layouts.app')

@push('style')
    <style>
        .inner-container {
            text-align: center;
            margin-top: 20%;
        }

        .form-container {
            text-align: center;
        }

        .btn-submit {
            width: 15em;
        }

        .lb-age {
            display: block;
            font-size: 20px;
        }

        #age {
            text-align: center;
            display: inline-block;
            width: 30%;
        }

    </style>
@endpush

@section('content')
    @php
    use App\Includes\Constant;
    @endphp

    <div class="container" style="height: 100%">
        <div class="inner-container">
            <?php
            switch ($quiz) {
                case Constant::$RAVEN_QUIZ:
                    $action = route('raven');
                    $message = 'سن خود را انتخاب کنید';
                    break;
                case Constant::$MD_QUESTIONNAIRE_QUIZ:
                    $action = route('mdq-questionnaire');
                    $message = 'بازه سنی مورد نظر را انتخاب کنید';
                    break;
            }
            ?>

            <form method="GET" action="{{ $action }}">
                @csrf
                <div class="form-group">
                    <label class="lb-age" for="age">{{ $message }}</label>

                    <select class="form-control" name="age" id="age">
                        @switch($quiz)
                            @case(Constant::$RAVEN_QUIZ):
                                @for ($i = 9; $i <= 18; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            @break;
                            @case(Constant::$MD_QUESTIONNAIRE_QUIZ):
                                <option value={{Constant::$MD_LEVEL_ONE_TO_THREE}}>{{ Constant::$MD_LEVELS_TEXT[Constant::$MD_LEVEL_ONE_TO_THREE] }}</option>
                                <option value={{Constant::$MD_LEVEL_THREE_TO_SIX}}>{{ Constant::$MD_LEVELS_TEXT[Constant::$MD_LEVEL_THREE_TO_SIX] }}</option>
                            @break; 
                        @endswitch

                    </select>

                </div>

                <button class="btn btn-primary btn-submit" type="submit">تایید</button>


            </form>
        </div>


    </div>

@endsection

<script>

</script>
