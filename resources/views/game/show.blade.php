@extends('layouts.app')

@push('styles')
    <style>
        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .refresh {
            animation: rotate 1.5s linear infinite;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Game') }}</div>

                <div class="card-body">
                    <div class="text-center">
                        <img id="circle" src="{{ asset('img/circle.png') }}" alt="" height="250" width="250">
                        <p id="winner" class="display-1 d-none text-primary"></p>
                    </div>
                    <hr>
                    <div class="text-center">
                        <label class="font-weight-bold h5">Your Bet</label>
                        <select id="bet" class="custom-select col-auto">
                            <option selected>Not in</option>
                            @foreach (range(1, 12) as $number)
                                <option>{{ $number }}</option>
                            @endforeach
                        </select>
                        <hr>
                        <p class="font-weight-bold h5">Remaining Time</p>
                        <p id="timer" class="h5 text-danger"></p>
                        <hr>
                        <p id="result" class="h1"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        const circleElement = document.getElementById('circle');
        const timerElement = document.getElementById('timer');
        const winnerElement = document.getElementById('winner');
        const betElement = document.getElementById('bet');
        const resultElement = document.getElementById('result');
    </script>
@endpush