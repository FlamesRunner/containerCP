@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User management</div>
                <div class="card-body">
                    From this page, you may view, manage and add or remove users from the system.
                </div>
            </div>
            <br />
            @if (Session::get('error') == 'insufficient_perm')
                <div class="alert alert-danger">
                    You cannot delete users with greater permissions levels than yourself.
                </div>
            @endif
            @if (Session::get('error') == 'self')
                <div class="alert alert-danger">
                    You can't delete yourself, silly.
                </div>
            @endif
            {{ $users->links() }}
            @forelse ($users as $user) 
                <div class="card">
                    <div class="card-body">
                        <div class="btn-group">
                            <span class="btn btn-light" disabled="disabled">UID {{ $user->id }}</span>
                            <span class="btn btn-light" disabled="disabled">{{ $user->name }}</span>
                            @if ($user->role == 0) 
                                <span class="btn btn-danger" disabled="disabled">Root user</span>
                            @elseif ($user->role < 1000)
                                <span class="btn btn-warning" disabled="disabled">Administrator</span>
                            @else
                                <span class="btn btn-success" disabled="disabled">User</span>
                            @endif
                        </div>
                        <div style="float: right">
                            <div class="btn-group">
                                <a href="{{ route('admin.profile', [$user->id]) }}" class="btn btn-primary">Edit</a>
				                <a href="{{ route('admin.profile.delete', [$user->id])}}" class="btn btn-danger">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
            @empty
                <div class='alert alert-danger'>No users were found. That doesn't sound right.</div>
            @endforelse
            <br />
        </div>
    </div>
</div>
@endsection
