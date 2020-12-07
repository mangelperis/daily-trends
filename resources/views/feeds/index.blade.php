@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <h1>Your Latest Feeds</h1>
    <div class="row">
        <div class="col">
            <a class="btn btn-info "  href="{{route('feeds.create')}}" role="button">Create new</a>
        </div>
        <div class="col">
            {!! Form::open([
            'method' => 'GET',
            'route' => ['feeds.reload']
             ]) !!}
            {!! Form::submit('Reload Feeds', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    <hr>

    @if(Session::has('flash_message_succeed'))
        @include('layouts.alerts.flash_succeed')
    @elseif(Session::has('flash_message_error'))
        @include('layouts.alerts.flash_error')
    @endif

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Body</th>
                <th scope="col" class="col-2">Source</th>
                <th scope="col">Publisher</th>
                <th scope="col" >Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $feed)
                <tr>
                    <td><img class="img-fluid" src="{{$feed->image}}" alt="no-image"></td>
                    <th scope="row">{!! $feed->title !!}</th>
                    <td>{!! $feed->body !!}</td>
                    <td>{{$feed->source}}</td>
                    <td>{!!  $feed->publisher !!}</td>

                    <td>
                        <a class="btn btn-info"  href="{{route('feeds.edit', $feed->id)}}" role="button">Edit</a>
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['feeds.destroy', $feed->id]
                        ]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
@stop
