<div class="panel-body">
    <form class="form-inline" action="{{ route('admin/search') }}" method="POST">
        <select class="form-control" name="field">
            <option value="code">Code</option>
            <option value="url">URL</option>
        </select>
        <div class="form-group">
            <input type="text" class="form-control" name="search_text" placeholder="Search !">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
        {{ csrf_field() }}
    </form>
</div>
