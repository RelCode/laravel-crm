@extends('layouts.app')

@section('content')
    <div id="wrapper">
        @include('layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar')
                <div id="crm-content-container" class="container">
                    <div class="d-flex justify-content-between pt-2">
                        <h4 class="text text-primary">Create Lead</h4>
                        <a href="{{ route('leads') }}" class="btn btn-primary" title="Go Back"><i class="fa fa-arrow-left"></i></a>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-7">
                            <form action="{{ route('leads.create') }}" method="post">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="names" class="form-label mb-0 d-flex justify-content-between">
                                        First & Last Name
                                        @error('names')
                                            <span class="text text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="names" class="form-control @error('names') border-danger @enderror"
                                        id="names" aria-describedby="enter lead's full names" value="{{ old('names') }}" autofocus>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="profession" class="form-label mb-0 d-flex justify-content-between">
                                        Occupation
                                        @error('profession')
                                            <span class="text text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="profession" class="form-control @error('profession') border-danger @enderror"
                                        id="profession" aria-describedby="provide lead's profession" value="{{ old('profession') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label mb-0 d-flex justify-content-between">
                                        Email Address
                                        @error('email')
                                            <span class="text text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="email" class="form-control @error('email') border-danger @enderror"
                                        id="email" aria-describedby="enter lead's email address" value="{{ old('email') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label mb-0 d-flex justify-content-between">
                                        Phone Number
                                        @error('phone')
                                            <span class="text text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="phone" class="form-control @error('phone') border-danger @enderror"
                                        id="phone" aria-describedby="enter lead's contact number" value="{{ old('phone') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-primary form-control">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection