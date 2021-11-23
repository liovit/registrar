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
                            @php $session = session('status'); @endphp
                            {{ __($session) }}
                        </div>
                    @endif

                    <div class="col-12" style="overflow-x: scroll !important;">
                        <table id="garbage" class="table text-center">
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
                                {{-- @foreach($workers as $worker) --}}
                                <tr>
                                    <td>id</td>
                                    <td>name</td>
                                    <td>email</td>
                                    <td><a href="#">phone</a></td>
                                    <td><a href="#">company</a></td>
                                    <td>date</td>
                                    {{-- <td>
                                        <a href="{{ route('workers.show', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('View') }}"><i class="fa fa-external-link-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                        <a href="{{ route('workers.edit', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}"><i class="fa fa-pencil-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                        <a href="{{ route('workers.delete', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"><i class="fa fa-minus-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                    </td> --}}
                                </tr>
                                {{-- <tr>
                                    <td>{{ $worker->id }}</td>
                                    <td>{{ $worker->name }}</td>
                                    <td>{{ $worker->email }}</td>
                                    <td><a href="#">{{ $worker->phone }}</a></td>
                                    <td><a href="{{ route('companies.show', ['company' => $worker->company->id]) }}">{{ $worker->company->title }}</a></td>
                                    <td>{{ \Carbon\Carbon::parse($worker->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('workers.show', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('View') }}"><i class="fa fa-external-link-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                        <a href="{{ route('workers.edit', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}"><i class="fa fa-pencil-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                        <a href="{{ route('workers.delete', ['worker' => $worker->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"><i class="fa fa-minus-square" aria-hidden="true" style="font-size:20px;"></i></a>
                                    </td>
                                </tr> --}}
                                {{-- @endforeach --}}
                            </tbody>
                        </table>
                    </div>

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

                var table = $('#garbage').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('workers.getworkers') }}",
                    columns: [
                        {data: 'id'},
                        {data: 'name'},
                        {data: 'email'},
                        {data: 'phone'},
                        {data: 'company'},
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

                var table = $('#garbage').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('workers.getworkers') }}",
                    columns: [
                        {data: 'id'},
                        {data: 'name'},
                        {data: 'email'},
                        {data: 'phone'},
                        {data: 'company'},
                        {data: 'date'},
                    ],
                    "language": {
                        "url" : "//cdn.datatables.net/plug-ins/1.11.3/i18n/en-gb.json"
                    }
                });
                
            }

            $('.table tbody').on('click', '.view', function() {

                var row = $(this).closest('tr');
                var data = table.row(row).data().id;
                var url = "{{ route('workers.show', ':id') }}";
                url = url.replace(':id', data);
                window.location.href = url;

            });

            $('.table tbody').on('click', '.edit', function() {

                var row = $(this).closest('tr');
                var data = table.row(row).data().id;
                var url = "{{ route('workers.edit', ':id') }}";
                url = url.replace(':id', data);
                window.location.href = url;

            });

            $('.table tbody').on('click', '.delete', function() {

                var row = $(this).closest('tr');
                var data = table.row(row).data().id;
                var url = "{{ route('workers.delete', ':id') }}";
                url = url.replace(':id', data);
                window.location.href = url;

            });

        });

    </script>

@endsection