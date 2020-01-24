@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile management</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            There was an issue saving your profile:<br />
                                @foreach ($errors->all() as $error)
                                    - {{ $error }}<br />
                                @endforeach
                        </div>
                    @endif
                    @if (!empty(Session::get('success')))
                        <div class="alert alert-success">
                            Your profile was saved successfully.
                        </div>
                    @endif
                    {{ Form::open(array('route' => 'profile.save')) }}
                        {{ Form::token() }}
                        Name
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" />
                        <br />
                        Email address
                        <input type="text" class="form-control" disabled="disabled" value="{{ $user->email }}" />
                        <br />
                        Password
                        <input type="password" class="form-control" name="password_one" />
                        <br />
                        Confirm password
                        <input type="password" class="form-control" name="password_two" />
                        <br />
                        <input type="submit" class="btn btn-primary" value="Modify" />
                    {{ Form::close() }} 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
