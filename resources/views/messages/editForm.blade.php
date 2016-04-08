@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Edit message</div>
            @if(count($errors)>0)
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            @endif
            <div class="panel-body">
                <form action="{{ Request::url() }}" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    {!! method_field('PATCH') !!}

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Message</label>

                        <div class="col-sm-6">
                            <input type="text" name="message" id="message" class="form-control" value="{{ $message_title }}">
                        </div>
                    </div>

                    <!-- Add Message Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-plus"></i> Edit message
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection