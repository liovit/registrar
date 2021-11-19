@extends('layouts.app')

<title>{{ __('Companies') }} - {{ __('Registrar') }}</title>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><span>{{ __('Companies') }}</span> <a href="{{ route('companies.create') }}" class="float-right">{{ __('Add new company') }}</a></div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (count($companies) <= 0)
                        {{ __('Hello, please create your first ') }} <a href="{{ route('companies.create') }}">{{ __('company') }}</a> {{ __(' in order to start controlling registrar') }}.

                    @else
                    <div class="col-12" style="overflow-x: scroll !important;">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('E-Mail Address') }}</th>
                                    <th>{{ __('Website Link') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($companies as $company)
                                <tr>
                                    <td>{{ $company->id }}</td>
                                    <td>{{ $company->title }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td><a href="{{ $company->web_url }}">{{ $company->web_url }}</a></td>
                                    <td>{{ \Carbon\Carbon::parse($company->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($locale == 'en')
                                            <a href="{{ route('companies.show', ['company' => $company->id]) }}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-external-link-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                            <a href="{{ route('companies.edit', ['company' => $company->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                            <a href="{{ route('companies.delete', ['company' => $company->id]) }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                        @else
                                            <a href="{{ route('companies.show', ['company' => $company->id]) }}" data-toggle="tooltip" data-placement="top" title="Peržiūrėti"><i class="fa fa-external-link-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                            <a href="{{ route('companies.edit', ['company' => $company->id]) }}" data-toggle="tooltip" data-placement="top" title="Koreguoti"><i class="fa fa-pencil-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                            <a href="{{ route('companies.delete', ['company' => $company->id]) }}" data-toggle="tooltip" data-placement="top" title="Ištrinti"><i class="fa fa-minus-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <script>

        $(document).ready(function(){
            
            $('[data-toggle="tooltip"]').tooltip(); 

            var Language = $('html').attr('lang');

            if(Language == 'lt') {
                $('.table').DataTable({
                    "language": {
                        "url" : "//cdn.datatables.net/plug-ins/1.11.3/i18n/lt.json"
                    }
                });
            } else {
                $('.table').DataTable({
                    "language": {
                        "url" : "//cdn.datatables.net/plug-ins/1.11.3/i18n/en-gb.json"
                    }
                });
            }

        });

    </script>

@endsection
