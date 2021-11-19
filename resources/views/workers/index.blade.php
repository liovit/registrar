@extends('layouts.app')

<title>{{ __('Workers') }} - {{ __('Registrar') }}</title>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><span>{{ __('Workers') }}</span> <a href="{{ route('workers.create') }}" class="float-right">{{ __('Add new worker') }}</a></div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="col-12" style="overflow-x: scroll !important;">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('E-Mail Address') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Company') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($workers as $worker)
                                <tr>
                                    <td>{{ $worker->id }}</td>
                                    <td>{{ $worker->name }}</td>
                                    <td>{{ $worker->email }}</td>
                                    <td><a href="#">{{ $worker->phone }}</a></td>
                                    <td><a href="{{ route('companies.show', ['company' => $worker->company->id]) }}">{{ $worker->company->title }}</a></td>
                                    <td>{{ \Carbon\Carbon::parse($worker->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($locale == 'en')
                                            <a href="{{ route('workers.show', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-external-link-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                            <a href="{{ route('workers.edit', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                            <a href="{{ route('workers.delete', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                        @else
                                            <a href="{{ route('workers.show', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="Peržiūrėti"><i class="fa fa-external-link-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                            <a href="{{ route('workers.edit', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="Koreguoti"><i class="fa fa-pencil-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                            <a href="{{ route('workers.delete', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="Ištrinti"><i class="fa fa-minus-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
