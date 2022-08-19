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
                    <div class="row pt-3" id="main-row">
                        <div class="col-xs-12 col-md-5">
                            <form action="{{ route('leads.action',$lead->id) }}" method="post">
                                @csrf
                                <div class="btn-group">
                                    @foreach ($stages as $stage)
                                        <button type="submit" name="stage" value="{{$stage->id}}" class="btn btn-primary {{$stage->id == $lead->stage ? 'active' : ''}}">
                                            {{$stage->stage}}
                                        </button>
                                        <input type="hidden" name="{{$stage->id}}" value="{{ $stage->stage }}">
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="current" value="{{ $lead->current_stage }}">
                            </form>
                        </div>
                        <div class="col-xs-12 col-md-7">
                            <div class="accordion" id="accordionContainer">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Write A New Note
                                    </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionContainer">
                                    <div class="accordion-body">
                                        <form action="{{ route('leads.action',$lead->id) }}" method="post">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="header" class="form-label mb-0 d-flex justify-content-between">
                                                    Note Title
                                                    @error('title')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </label>
                                                <input type="text" name="title" class="form-control @error('title') border-danger @enderror"
                                                    id="title" aria-describedby="enter note's title" value="{{ old('title') }}" autofocus>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="body" class="form-label mb-0 d-flex justify-content-between">
                                                    Make Notes Below
                                                    @error('body')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </label>
                                                <textarea class="form-control @error('body') border-danger @enderror" name="body" id="body" rows="8">{{old('body') ? old('body') : ''}}</textarea>
                                            </div>
                                            <div class="form-group mb-3">
                                                <button type="submit" name="notes" value="submit" class="btn btn-primary form-control">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                                @foreach ($notes as $note)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#item_{{ $note->id }}" aria-expanded="false" aria-controls="item_{{ $note->id }}">
                                                {{$note->title}} <span class="text-muted" style="position: absolute;right:45px">{{\Carbon\Carbon::parse($note->created_at)->diffForHumans()}}</span>
                                            </button>
                                        </h2>
                                        <div id="item_{{ $note->id }}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionContainer">
                                        <div class="accordion-body">
                                            {!! nl2br($note->body) !!}
                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection