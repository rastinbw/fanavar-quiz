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
        .result-box {
            border: 1px solid #000;
            padding: 10px;
            width: 30%;
            text-align: center;
            border-radius: 10px;
            display: inline-block;
            font-size: 20px;
        }
        
        .btn-home {
            display: inline-block;
            width: 30%;
            margin-top: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        @if ($result)
            <div class="result-box">
                <p>امتیاز شما در این آزمون معادل {{ $result['iq'] }} میباشد</p>
                <p>از لحاظ طبقه بندی هوش در دسته {{ $result['level'] }} قرار میگیرید</p>
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
