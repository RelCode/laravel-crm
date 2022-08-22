@extends('layouts.app')

@section('content')
    <div id="wrapper">
        @include('layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar')
                <div id="crm-content-container" class="container">
                    <div class="d-flex justify-content-between pt-2">
                        <h4 class="text text-primary">Customers</h4>
                        <div>
                            <a href="{{ route('customers.create') }}" class="btn btn-primary" title="Create New Customer"><i class="fa fa-plus"></i></a>  <a href="/trash" class="btn btn-danger" title="View Deleted Customers"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                    <div class="row" id="main-row">
                        @if ($customers->count() > 0)
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Names</th>
                                        <th>Profession</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Date Added</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $index => $customer)
                                        <tr>
                                            <th>{{$customer->name}}</th>
                                            <th>{{$customer->profession}}</th>
                                            <th>{{$customer->email}}</th>
                                            <th>{{$customer->phone}}</th>
                                            <th>{{$customer->created_at}}</th>
                                            <th>
                                                <?php
                                                    $dot = is_null($customer->city) ? '<div class="dot"></div>' : '';
                                                ?>
                                                <a href="{{ route('customers.history',$customer->id) }}" class="btn btn-primary p-1"><i class="fa fa-cog"></i></a>
                                                <a href="{{ route('customers.edit',$customer->id) }}" class="btn btn-warning p-1 position-relative"><i class="fa fa-edit"></i><?= $dot ?></a>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $customers->links() }}
                        </div>
                        @else
                            <div class="col-xs-12 col-md-6 offset-md-3">
                                <p class="h4 text-secondary">You Have No Customers, <a href="{{ route('customers') }}" class="text-primary">Add One</a></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection