@extends('layouts.app')

<title>{{ __('Workers') }} - {{ __('Registrar') }}</title>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><span>{{ $worker->name }}</span> <a href="{{ route('workers.index') }}" class="float-right">{{ __('Back to the list') }}</a></div>

                <div class="card-body">

                    <table class="table table-striped">
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <td>{{ $worker->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('E-Mail Address') }}</th>
                            <td>{{ $worker->email }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Phone') }}</th>
                            <td><a href="#">{{ $worker->phone }}</a></td>
                        </tr>
                        <tr>
                            <th>{{ __('Company') }}</th>
                            <td><a href="{{ route('companies.show', ['company' => $worker->company->id]) }}">{{ $worker->company->title }}</a></td>
                        </tr>
                    </table>

                    <div class="mt-4 text-center">

                        <form action="{{ route('workers.destroy', ['worker' => $worker->id]) }}" method="post">

                            {{ method_field('DELETE') }}
                            @csrf
                        
                            <p class="delete-text">
                                {{  __('Are you sure you want to delete this worker?') }}
                            </p>

                            <a class="btn btn-lg btn-danger" href="{{ route('workers.index') }}">{{ __('No') }}</a>

                            <button class="btn btn-lg btn-success" type="submit">{{ __('Yes') }}</button>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
