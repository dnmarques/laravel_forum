@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $topic_title }}</div>
                    <div class="panel-body">
                        @if(count($messages) > 0)
                            <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <th>CONTENT</th>
                                    <th>WHO</th>
                                    <th>WHEN</th>
                                </tr>
                                @foreach($messages as $message)
                                <tr>
                                    <td>{{ $message->id }}</td>
                                    <td>{{ $message->content }}</td>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->created_at }}</td>
                                </tr>
                                @endforeach
                            </table>
                        @else
                            <p>There are no messages in this topic</p>
                        @endif
                    </div>
            </div>
        </div>
    </div>
    @include('messages.form')
</div>
@endsection
