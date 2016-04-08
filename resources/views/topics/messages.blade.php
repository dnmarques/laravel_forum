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
                                        @can('destroy', $message)
                                        <td>
                                            <form action="{{ Request::url() . '/message/'. $message->id }}" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}

                                                <button type="submit" id="delete-message-{{ $message->id }}" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                                            </form>
                                        </td>
                                        @endcan
                                        <td>
                                            <form action="{{ '/message/'. $message->topic_id . '/' . $message->id }}" method="GET>
                                                {!! csrf_field() !!}

                                                <button type="submit" id="update-message-{{ $message->id }}" class="btn btn-primary">
                                                    <i class="glyphicon glyphicon-pencil"></i> Edit
                                                </button>
                                            </form>
                                        </td>
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
