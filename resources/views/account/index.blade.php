@extends('layouts.master')

@section('title', 'Account')

@section('content')

    <div class="account_index mt-5">
        <div class="container">

            <div class="row">

                <div class="col-6 offset-3">

                    <h1>Your Account</h1>

                    {{ Form::open(['route' => ['account.update', Auth::id()], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                        {{ Form::hidden('_method', 'PUT') }}
                        {{ Form::bsText('name', old('name') ? old('name') : $user->name, ['label' => 'Name']) }}
                        {{-- {{ Form::bsFile('image', '', ['label' => 'Image (Only jpg)']) }} --}}
                        <div class="form-group">
                            <label for="image">Image (Only jpg)</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}

                </div>

            </div>

            <hr>

            @if (Storage::disk('local')->exists('public/user'. $user->id . '/' . $user->image))
                <div class="row">
                    <div class="col-6 offset-3 text-center">
                        <img src="{{ asset('storage/user'. $user->id . '/' . $user->image) }}" class="img-fluid">
                    </div>
                </div>
            @endif

        </div>
    </div>
    
@endsection