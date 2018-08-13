@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
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
                        </tr>
                        </thead>
                        <tbody>
                            @each('partials.url', $urls, 'url')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
