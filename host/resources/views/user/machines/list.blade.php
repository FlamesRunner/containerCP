@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">VM management</div>
                <div class="card-body">
                    From this page, you may manage the VMs in your account.
                </div>
            </div>
            <br />
            {{ $vms->links() }}
            @forelse ($vms as $vm)
                <div class="card">
                    <div class="card-body">
                        <div class="btn-group">
                            <span class="btn btn-secondary" disabled="disabled">VM{{ $vm->id }}</span>
                            <span class="btn btn-secondary" disabled="disabled">{{ $vm->host }}</span>
                        </div>
                        <div style="float: right">
                            <a href="{{ route('vm.manage', [$vm->id]) }}" class="btn btn-primary">Manage</a>
                        </div>
                    </div>
                </div>
                <br />
            @empty
                <div class='alert alert-danger'>No virtual machines were found.</div>
            @endforelse
            <br />
        </div>
    </div>
</div>
@endsection
