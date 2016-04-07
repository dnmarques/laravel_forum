@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Topics list</div>

                <div class="panel-body">
                    @if(count($topics) > 0)
                        <table class="table">
                        <tr>
                            <th>TITULO</th>
                            <th>CRIADOR</th>
                            <th></th>
                        </tr>
                        @foreach($topics as $topic)
                            <tr>
                                <td><a href="{{ url('topic/'.$topic->id) }}">{{ $topic->title }}</a></td>
                                <td>{{ $topic->name}}</td>
                                <td>
                                @can('destroy', $topic)
                                        <form action="{{ url('topic/'.$topic->id) }}" method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}

                                            <button type="submit" id="delete-topic-{{ $topic->id }}" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                    @endcan
                            </tr>
                        @endforeach
                        </table>
                    @else
                        <p>There are no topics.</p>
                    @endif
                    <form action="{{ url('topic') }}" method="GET">

                        <button type="submit" id="button_insert_topic" class="btn btn-default">
                            <i class="fa fa-plus"></i> Create new topic
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
