@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('500 - Internal Server Error') }}</div>

                    <div class="card-body">
                        {{ __('Sorry, there was an internal server error. Please try again later.') }}
                        <br><br>
                        <a href="{{ url('/') }}">{{ __('Return to homepage') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
