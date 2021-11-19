@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (count($companies) > 0)
                        {{ __('You are logged in. Here you can control ') }} <a href="{{ route('companies.index') }}">{{ __('companies') }}</a> {{ __(' and ') }} <a href="{{ route('workers.index') }}">{{ __('workers') }}</a>.
                    @else
                        {{ __('Hello, please create your first ') }} <a href="{{ route('companies.create') }}">{{ __('company') }}</a> {{ __(' in order to start controlling registrar') }}.
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
