@extends('layouts.app')

<title>{{ __('Workers') }} - {{ __('Registrar') }}</title>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Worker Creation') }}</div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('workers.store') }}" method="post" enctype="multipart/form-data">

                        @csrf
            
                        <div class="row">
                            <div class="col-12">
                                <label for="">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">{{ __('E-Mail Address') }}</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">{{ __('Phone') }}</label>
                                <input type="text" name="phone" class="form-control" placeholder="37060335577" value="{{ old('phone') }}">
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">{{ __('Company') }}</label>
                                <select name="company_id" class="form-control" id="">
                                    <option value="" selected disabled>{{ __('Choose company') }}</option>
                                    @foreach($companies->chunk(10) as $ten)
                                        @foreach($ten as $company)
                                            <option value="{{ $company['id'] }}">{{ $company['title'] }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
            
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success col-12 float-right">{{ __('Create') }}</button>
                        </div>
            
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

