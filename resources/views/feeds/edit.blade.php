@extends('layouts.master')

@section('title', 'Edit Feed')

@section('content')

    <h1>Edditing -"{{ $feed->title }}"-</h1>
    <p class="lead">Edit this feed below.
        <a class="btn btn-info"  href="{{route('feeds.index')}}" role="button">Go back</a>
    </p>

    <hr>
    @include('layouts.alerts.errors')

    @if(Session::has('flash_message_succeed'))
        @include('layouts.alerts.flash_succeed')
    @elseif(Session::has('flash_message_error'))
        @include('layouts.alerts.flash_error')
    @endif

    {!! Form::model($feed, [
        'method' => 'PATCH',
        'route' => ['feeds.update', $feed->id]
    ]) !!}

    <div class="form-group">
        {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', 'Body:', ['class' => 'control-label']) !!}
        {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('image', 'Image:', ['class' => 'control-label']) !!}
        {!! Form::text('image', null, ['class' => 'form-control']) !!}
    </div>


    <div class="form-group">
        {!! Form::label('source', 'Source:', ['class' => 'control-label']) !!}
        {!! Form::text('source', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('publisher', 'Publisher:', ['class' => 'control-label']) !!}
        {!! Form::text('publisher', null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Update Feed', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}

@stop
