@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editing UID{{ $user->id }} ({{ $user->name }})</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            There was an issue saving the profile:<br />
                                @foreach ($errors->all() as $error)
                                    - {{ $error }}<br />
                                @endforeach
                        </div>
                    @endif
                    @if (!empty(Session::get('success')))
                        <div class="alert alert-success">
                            The profile was saved successfully.
                        </div>
                    @endif
                    @if (Session::get('error') == 'insufficient_perm')
                        <div class="alert alert-danger">
                            You cannot set this user's permission level to one that is equivalent or higher than yours.
                        </div>
                    @elseif (Session::get('error') == 'self')
                        <div class="alert alert-warning">
                            Please note that you cannot modify your account from this interface. Please use the profile management option under your name.
                        </div>
                    @endif

                    {{ Form::open(array('route' => ['admin.profile.save', $user->id])) }}
                        {{ Form::token() }}
                        @if (Session::get('error') == 'self')
                            Name
                            <input type="text" class="form-control" disabled="disabled" value="{{ $user->name }}" />
                            <br />
                            Email address
                            <input type="text" class="form-control" disabled="disabled" value="{{ $user->email }}" />
                            <br />
                            Role
                            <input type="number" class="form-control" disabled="disabled" value="{{ $user->role }}" />
                            <br />
                            Password
                            <input type="password" class="form-control" disabled="disabled" value='*************' />
                        @else
                            <input type="hidden" name="id" value="{{ $user->id }}" />
                            Name
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" />
                            <br />
                            Email address
                            <input type="text" class="form-control" name="email" value="{{ $user->email }}" />
                            <br />
                            Role
                            <input type="number" class="form-control" name="role" min="{{ Auth::user()->role + 1 }}" value="{{ $user->role }}" />
                            <br />
                            Password
                            <input type="password" class="form-control" name="password" />
                            <br />
                            <input type="submit" class="btn btn-primary" value="Modify" />
                        @endif
                    {{ Form::close() }} 
                </div>
            </div>
            <br />
            <div class="card">
                <div class="card-header">Guide</div>
                <div class="card-body">
                    <ul>
                    <li>Permissions with containerCP are fairly simple; a permissions level of 0 represents the root user, a level between 1 (inclusive) to 999 (inclusive) are designated as administrators and any levels 1000 or above are standard users.</li>
                    <li>You may change the permissions level of any user that has less privileges than yourself to anything after your permissions level.</li>
                    <li>Consequently, the root user cannot have its permissions changed, and any administrator with a greater level than another administrator can demote that user to standard privileges.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
