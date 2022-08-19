@extends('layouts.app')

@section('content')
    <div id="wrapper">
        @include('layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar')
                <div id="crm-content-container" class="container">
                    <div class="d-flex justify-content-between pt-2">
                        <h4 class="text text-primary">Leads</h4>
                        <div>
                            <a href="{{ route('leads.create') }}" class="btn btn-primary" title="Create New Lead"><i class="fa fa-plus"></i></a>  <a href="/trash" class="btn btn-danger" title="View Deleted Leads"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                    <div class="row" id="main-row">
                        @if ($leads->count() > 0)
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Names</th>
                                        <th>Profession</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Created By</th>
                                        <th>Stage</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leads as $index => $lead)
                                        <tr>
                                            <th>{{$lead->names}}</th>
                                            <th>{{$lead->profession}}</th>
                                            <th>{{$lead->email}}</th>
                                            <th>{{$lead->phone}}</th>
                                            <th>{{preg_replace('/(?<=\w)./', ' ', $lead->creator)}}</th>
                                            <th>{{$lead->current_stage}}</th>
                                            <th>
                                                <a href="{{ route('leads.action',$lead->id) }}" class="btn btn-primary p-1"><i class="fa fa-cog"></i></a>
                                                <a href="{{ route('leads.edit',$lead->id) }}" class="btn btn-warning p-1"><i class="fa fa-edit"></i></a>
                                                    @csrf
                                                    <button type="button" data-user="{{$lead->id}}" class="btn btn-danger delete-lead p-1">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $leads->links() }}
                        </div>
                        @else
                            <div class="col-xs-12 col-md-6 offset-md-3">
                                <p class="h4 text-secondary">You Have No Leads, <a href="{{ route('leads.create') }}" class="text-primary">Create One</a></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection