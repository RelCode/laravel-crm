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
                        <a href="{{ route('leads.create') }}" class="btn btn-primary" title="Create New Lead"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection