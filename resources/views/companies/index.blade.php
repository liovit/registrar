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
                            @php $session = session('status'); @endphp
                            {{ __($session) }}
                        </div>
                    @endif

                    {{-- @if ($totalRecords <= 0)
                        {{ __('Hello, please create your first ') }} <a href="{{ route('companies.create') }}">{{ __('company') }}</a> {{ __(' in order to start controlling registrar') }}.

                    @else --}}
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
                                {{-- @foreach($companies as $company) --}}
                                <tr>
                                    <td>id</td>
                                    <td>title</td>
                                    <td>email</td>
                                    <td><a href="#">weburl</a></td>
                                    <td>date</td>
                                    {{-- <td> --}}
                                        {{-- <a href="{{ route('companies.show', ['company' => $company->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('View') }}"><i class="fa fa-external-link-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                        <a href="{{ route('companies.edit', ['company' => $company->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}"><i class="fa fa-pencil-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                        <a href="{{ route('companies.delete', ['company' => $company->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"><i class="fa fa-minus-square" aria-hidden="true" style="font-size:20px;"></i></a> --}}
                                    {{-- </td> --}}
                                </tr>
                                {{-- @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                    {{-- @endif --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <script>

        $(document).ready(function(){

            var Language = $('html').attr('lang');

            if(Language == 'lt') {
                var table = $('.table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('companies.getcompanies') }}",
                    columns: [
                        {data: 'id'},
                        {data: 'title'},
                        {data: 'email'},
                        {
                            render: function( data, type, row, meta ) {
                                return '<a href="'+row.web_url+'">'+row.web_url+'</a>';
                            }
                        },
                        {data: 'date'},
                        {
                            defaultContent: 
                            "<a href='#' class='view' data-toggle='tooltip' data-placement='top' title='{{ __('View') }}'><i class='fa fa-external-link-square' aria-hidden='true' style='font-size:20px;'></i></a>\
                             <a href='#' class='edit' data-toggle='tooltip' data-placement='top' title='{{ __('Edit') }}'><i class='fa fa-pencil-square' aria-hidden='true' style='font-size:20px;'></i></a>\
                             <a href='#' class='delete' data-toggle='tooltip' data-placement='top' title='{{ __('Delete') }}'><i class='fa fa-minus-square' aria-hidden='true' style='font-size:20px;'></i></a>"
                        },
                    ],
                    "language": {
                        "url" : "//cdn.datatables.net/plug-ins/1.11.3/i18n/lt.json"
                    }
                });
            } else {
                var table = $('.table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('companies.getcompanies') }}",
                    columns: [
                        {data: 'id'},
                        {data: 'title'},
                        {data: 'email'},
                        {data: 'web_url'},
                        {data: 'date'},
                        {
                            defaultContent: 
                            "<a href='#' class='view' data-toggle='tooltip' data-placement='top' title='{{ __('View') }}'><i class='fa fa-external-link-square' aria-hidden='true' style='font-size:20px;'></i></a>\
                             <a href='#' class='edit' data-toggle='tooltip' data-placement='top' title='{{ __('Edit') }}'><i class='fa fa-pencil-square' aria-hidden='true' style='font-size:20px;'></i></a>\
                             <a href='#' class='delete' data-toggle='tooltip' data-placement='top' title='{{ __('Delete') }}'><i class='fa fa-minus-square' aria-hidden='true' style='font-size:20px;'></i></a>"
                        },
                    ],
                    "language": {
                        "url" : "//cdn.datatables.net/plug-ins/1.11.3/i18n/en-gb.json"
                    }
                });
            }

            $('.table tbody').on('click', '.view', function() {

                var row = $(this).closest('tr');
                var data = table.row(row).data().id;
                var url = "{{ route('companies.show', ':id') }}";
                url = url.replace(':id', data);
                window.location.href = url;
                    
            });

            $('.table tbody').on('click', '.edit', function() {

                var row = $(this).closest('tr');
                var data = table.row(row).data().id;
                var url = "{{ route('companies.edit', ':id') }}";
                url = url.replace(':id', data);
                window.location.href = url;

            });

            $('.table tbody').on('click', '.delete', function() {

                var row = $(this).closest('tr');
                var data = table.row(row).data().id;
                var url = "{{ route('companies.delete', ':id') }}";
                url = url.replace(':id', data);
                window.location.href = url;

            });

        });

    </script>

@endsection
