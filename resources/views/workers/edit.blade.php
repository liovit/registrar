@extends('layouts.app')

<title>{{ __('Workers') }} - {{ __('Registrar') }}</title>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Worker Creation') }} <a href="{{ route('workers.index') }}" class="float-right">{{ __('Back to the list') }}</a></div>

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

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('workers.update', ['worker' => $worker->id]) }}" method="post" enctype="multipart/form-data">

                        {{ method_field('PUT') }}
                        @csrf
            
                        <div class="row">
                            <div class="col-12">
                                <label for="">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control" value="{{ $worker->name }}">
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">{{ __('E-Mail Address') }}</label>
                                <input type="email" name="email" class="form-control" value="{{ $worker->email }}">
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">{{ __('Phone') }}</label>
                                <input type="text" name="phone" class="form-control" value="{{ $worker->phone }}">
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">{{ __('Company') }}</label>
                                <select name="company_id" class="form-control" id="">
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" @if($company->id == $worker->company->id) selected @endif>{{ $company->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
            
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success col-12 float-right">{{ __('Update') }}</button>
                        </div>
            
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

