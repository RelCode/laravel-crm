@extends('layouts.app')

@section('content')
    <div id="wrapper">
        @include('layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar')
                <div id="crm-content-container" class="container">
                    <div class="d-flex justify-content-between pt-2">
                        <h4 class="text text-primary"><a href="{{ route('leads.edit',$lead->id) }}">{{$lead->names}}</a></h4>
                        <div>
                            <a href="{{ route('leads') }}" class="btn btn-primary" title="Go Back"><i class="fa fa-arrow-left"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-5">
                            <form action="{{ route('leads.action',$lead->id) }}" method="post">
                                @csrf
                                <div class="btn-group">
                                    @foreach ($stages as $stage)
                                        <button type="submit" name="stage" value="{{$stage->id}}" class="btn btn-primary {{$stage->id == $lead->stage ? 'active' : ''}}">
                                            {{$stage->stage}}
                                        </button>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection