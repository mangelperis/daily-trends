@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <a class="btn btn-info"  href="{{route('feeds.create')}}" role="button">Create new</a>


        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">title</th>
                <th scope="col">body</th>
                <th scope="col">image</th>
                <th scope="col">source</th>
                <th scope="col">publisher</th>
                <th scope="col">created</th>
                <th scope="col">updated</th>
                <th scope="col">action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $feed)
                <tr>
                    <th scope="row">{{$feed->title}}</th>
                    <td>{{$feed->body}}</td>
                    <td><img src="{{$feed->image}}" alt=""></td>
                    <td>{{$feed->source}}</td>
                    <td>{{$feed->publisher}}</td>
                    <td>{{$feed->created_at}}</td>
                    <td>{{$feed->updated_at}}</td>
                    <td>
                        <a class="btn btn-info"  href="{{route('feeds.edit', $feed->id)}}" role="button">Edit</a>
                        <a class="btn btn-danger" href="{{route('feeds.destroy', $feed->id)}}" role="button">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
@stop
