@extends('layouts.app')

<title>{{ __('Companies') }} - {{ __('Registrar') }}</title>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><span>{{ $company->title }}</span> <a href="{{ route('companies.index') }}" class="float-right">{{ __('Back to the list') }}</a></div>

                <div class="card-body">

                    <table class="table table-striped">
                        @if($company->logo)
                            <tr>
                                <th>{{ __('Logo') }}</th>
                                <td><img src="{{ url($company->logo) }}" class="logo" alt=""></td>
                            </tr>
                        @endif
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <td>{{ $company->title }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('E-Mail Address') }}</th>
                            <td>{{ $company->email }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Website Link') }}</th>
                            <td><a href="{{ $company->web_url }}">{{ $company->web_url }}</a></td>
                        </tr>
                    </table>

                    <div class="mt-4 text-center">

                        <form action="{{ route('companies.destroy', ['company' => $company->id]) }}" method="post">

                            {{ method_field('DELETE') }}
                            @csrf
                        
                            <p class="delete-text">
                                {{  __('Are you sure you want to delete this company?') }}
                            </p>

                            <a class="btn btn-lg btn-danger" href="{{ route('companies.index') }}">{{ __('No') }}</a>

                            <button class="btn btn-lg btn-success" type="submit">{{ __('Yes') }}</button>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
