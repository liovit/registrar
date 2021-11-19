@extends('layouts.app')

<title>{{ __('Companies') }} - {{ __('Registrar') }}</title>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Company Creation') }}</div>

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

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('companies.store') }}" method="post" enctype="multipart/form-data">

                        @csrf
            
                        <div class="row">
                            <div class="col-12">
                                <label for="">{{ __('Title') }}</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">{{ __('E-Mail Address') }}</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">{{ __('Website Link') }}</label>
                                <input type="text" name="web_url" class="form-control" value="https://">
                            </div>
                            <div class="col-12 mt-2">
                                <label for="">{{ __('Logo') }}</label>
                                <input type="file" name="logo" class="form-control">
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

