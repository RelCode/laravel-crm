@extends('layouts.app')

@section('content')
    <div id="wrapper">
        @include('layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar')
                <div id="crm-content-container" class="container">
                    <div class="d-flex justify-content-between pt-2">
                        <h4 class="text text-primary">Edit Lead</h4>
                        <a href="{{ route('leads') }}" class="btn btn-primary" title="Go Back"><i class="fa fa-arrow-left"></i></a>
                    </div>
                    <div class="row">
                        @if ($lead->count() > 0)
                            <div class="col-xs-12 col-sm-8 col-md-7">
                                <form action="{{ route('leads.edit',$lead[0]->id) }}" method="post">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="names" class="form-label mb-0 d-flex justify-content-between">
                                            First & Last Name
                                            @error('names')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                        <input type="text" name="names" class="form-control @error('names') border-danger @enderror"
                                            id="names" aria-describedby="enter lead's full names" value="{{ old('names') ?? $lead[0]->names }}" autofocus>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="profession" class="form-label mb-0 d-flex justify-content-between">
                                            Occupation
                                            @error('profession')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                        <input type="text" name="profession" class="form-control @error('profession') border-danger @enderror"
                                            id="profession" aria-describedby="provide lead's profession" value="{{ old('profession') ?? $lead[0]->profession }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label mb-0 d-flex justify-content-between">
                                            Email Address
                                            @error('email')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                        <input type="text" name="email" class="form-control @error('email') border-danger @enderror"
                                            id="email" aria-describedby="enter lead's email address" value="{{ old('email') ?? $lead[0]->email }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label mb-0 d-flex justify-content-between">
                                            Phone Number
                                            @error('phone')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                        <input type="text" name="phone" class="form-control @error('phone') border-danger @enderror"
                                            id="phone" aria-describedby="enter lead's contact number" value="{{ old('phone') ?? $lead[0]->phone }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="stage" class="form-label mb-0 d-flex justify-content-between">
                                            Select Stage
                                            @error('stage')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                        <select name="stage" id="stage" class="form-control @error('stage') border-danger @enderror" aria-describedby="select lead current stage">
                                            <option value=""></option>
                                            @foreach ($stages as $stage)
                                                <option value="{{ $stage->id }}" {{$lead[0]->stage == $stage->id ? 'selected' : ''}}>{{ $stage->stage }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-primary form-control">Submit</button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="col-xs-12 col-md-6 offset-md-3">
                                <p class="h4 text-danger">Invalid Lead ID Provided</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection