<form action="{{ url('dashboard/editUsername') }}" method="POST" class="form-horizontal">
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="col-sm-3 control-label">New username:</label>

        <div class="col-sm-6">
            <input type="text" name="username" id="username" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-default">
                <i class="fa fa-plus"></i> Edit username
            </button>
        </div>
    </div>
</form>