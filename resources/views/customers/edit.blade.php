@extends('layouts.app')

@section('content')
    <div id="wrapper">
        @include('layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar')
                <div id="crm-content-container" class="container">
                    <div class="d-flex justify-content-between pt-2">
                        <h4 class="text text-primary">Edit {{$customer->name}}</h4>
                        <a href="{{ route('customers') }}" class="btn btn-primary" title="Go Back"><i class="fa fa-arrow-left"></i></a>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-7">
                            <form action="{{ route('customers.edit',$customer->id) }}" method="post">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label mb-0 d-flex justify-content-between">
                                        First & Last Name
                                        @error('name')
                                            <span class="text text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="name" class="form-control @error('name') border-danger @enderror"
                                        id="name" aria-describedby="enter customer's full name" value="{{ old('name') ? old('name') : $customer->name }}" autofocus>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="profession" class="form-label mb-0 d-flex justify-content-between">
                                        Occupation
                                        @error('profession')
                                            <span class="text text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="profession" class="form-control @error('profession') border-danger @enderror"
                                        id="profession" aria-describedby="provide customer's profession" value="{{ old('profession') ? old('profession') : $customer->profession }}">
                                </div>
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6">
                                            <div class="form-group mb-0">
                                                <label for="email" class="form-label mb-0 d-flex justify-content-between text-overflow">
                                                    Email
                                                    @error('email')
                                                        <span class="text text-danger text-overflow">{{ $message }}</span>
                                                    @enderror
                                                </label>
                                                <input type="text" name="email" class="form-control @error('email') border-danger @enderror"
                                                    id="email" aria-describedby="enter customer's email address" value="{{ old('email') ? old('email') : $customer->email }}">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <div class="form-group mb-0">
                                                <label for="phone" class="form-label mb-0 d-flex justify-content-between">
                                                    Phone Number
                                                    @error('phone')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </label>
                                                <input type="text" name="phone" class="form-control @error('phone') border-danger @enderror"
                                        id="phone" aria-describedby="enter customer's contact number" value="{{ old('phone') ? old('phone') : $customer->phone }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label mb-0 d-flex justify-content-between">
                                        Street Address
                                        @error('address')
                                            <span class="text text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="address" class="form-control @error('address') border-danger @enderror"
                                        id="address" aria-describedby="enter home address" value="{{ old('address') ? old('address') : $customer->address }}">
                                </div>
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6">
                                            <div class="form-group mb-0">
                                                <label for="province" class="form-label mb-0 d-flex justify-content-between">
                                                    Province
                                                    @error('province')
                                                        <span class="text text-danger text-overflow">{{ $message }}</span>
                                                    @enderror
                                                </label>
                                                <select name="province" id="province" class="form-control @error('province') border-danger @enderror">
                                                    <option value=""></option>
                                                </select>
                                                <input type="hidden" value="{{ $customer->province }}" id="current_province">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <div class="form-group mb-0">
                                                <label for="city" class="form-label mb-0 d-flex justify-content-between">
                                                    City
                                                    @error('city')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </label>
                                                <select name="city" id="city" class="form-control @error('city') border-danger @enderror">
                                                    <option value="{{ $city != '' ? $city->id : ''}}">{{$city != '' ? $city->name : ''}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
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