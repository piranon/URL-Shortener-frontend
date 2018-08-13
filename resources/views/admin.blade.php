@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('success') === true)
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @elseif (session('success') === false)
                        <div class="alert alert-danger">
                            {{ session('message') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">code</th>
                            <th scope="col">hits</th>
                            <th scope="col">url</th>
                            <th scope="col">status</th>
                            <th scope="col">expires</th>
                            <th scope="col">created</th>
                            <th scope="col">updated</th>
                            <th scope="col">action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @each('partials.url', $urls, 'url')
                        </tbody>
                    </table>
                    <form id="delete-form" action="{{ route('admin/delete') }}" method="POST" style="display: none;">
                        <input type="hidden" id="delete-id" name="id">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
