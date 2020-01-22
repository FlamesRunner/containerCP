@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Node management</div>
                <div class="card-body">
                    From this page, you may view, manage and add or remove nodes from your account.
                </div>
            </div>
            <br />
            {{ $nodes->links() }}
            @forelse ($nodes as $node) 
                <div class="card">
                    <div class="card-body">
                        <div class="btn-group">
                            <span class="btn btn-light" disabled="disabled">{{ $node->name }}</span>
                            <span class="btn btn-light" disabled="disabled">{{ $node->host }}</span>
                        </div>
                        <div style="float: right">
                            <button class="btn btn-success">Manage</button>
                        </div>
                    </div>
                </div>
                <br />
            @empty
                <div class='alert alert-danger'>No nodes were found.</div>
            @endforelse
            <br />
        </div>
    </div>
</div>
@endsection
