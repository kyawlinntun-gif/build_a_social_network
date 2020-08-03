@extends('layouts.master')

@section('title', 'Welcome')

@section('content')

    <div class="container mt-3">

        <div class="row">

            <div class="col-md-6">

                <h1>Sign Up</h1>

                {{ Form::open(['url' => 'register', 'method' => 'post']) }}
                    {{ Form::bsText('name', '', ['label' => 'Your Name']) }}
                    @include('messages.errors.name')
                    {{ Form::bsText('email', '', ['label' => 'Your E-mail']) }}
                    @include('messages.errors.email')
                    {{ Form::bsPassword('password', ['label' => 'Your Password']) }}
                    @include('messages.errors.password')
                    {{ Form::bsPassword('confirm_password', ['label' => 'Confirm Password']) }}
                    @include('messages\errors\confirm_password')
                    {{ Form::submit('Submit', ['class' => 'btn btn-primary d-block mt-2']) }}
                {{ Form::close() }}

            </div>

            <div class="col-md-6">

                <h1>Sign In</h1>
                @include('messages\errors\unsuccess')
                {{ Form::open(['url' => 'login', 'method' => 'post']) }}
                    {{ Form::bsText('login_email', '', ['label' => 'Your E-mail']) }}
                    {{-- @include('messages\errors\email') --}}
                    @error('login_email')
                        <div class="btn btn-danger">{{ $message }}</div>
                    @enderror
                    {{ Form::bsPassword('login_password', ['label' => 'Your Password']) }}
                    {{-- @include('messages\errors\password') --}}
                    @error('login_password')
                        <div class="btn btn-danger">{{ $message }}</div>
                    @enderror
                    {{ Form::submit('Submit', ['class' => 'btn btn-primary d-block mt-2']) }}
                {{ Form::close() }}

            </div>

        </div>

    </div>
    
@endsection