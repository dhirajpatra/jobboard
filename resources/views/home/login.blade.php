<?php
/**
 * Created by PhpStorm.
 * User: dhirajpatra
 * Date: 16/3/17
 * Time: 11:43 AM
 */
?>
<!-- app/views/login.blade.php -->

@extends('layouts.default')

@section('content')
    <div id="container">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        @if(isset($success))
            <div class="alert alert-success"> {{$success}} </div>
        @endif
        <div class="page-header">&nbsp;</div>
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <h1>Login to JobBoard</h1>


                    {{ Form::open(['route' => 'login_post']) }}

                    <!-- if there are login errors, show them here -->
                    <div class="form-group">
                        {{ $errors->first('email') }}
                        {{ $errors->first('password') }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('email', 'Email Address') }}
                        {{ Form::text('email', Input::old('email'), array('required', 'placeholder' => 'your email')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('password', 'Password') }}
                        {{ Form::password('password', array('required')) }}
                    </div>

                    <div class="form-group">
                    {{ Form::submit('Submit') }}
                    </div>
                    {{ Form::close() }}

@stop
                    </div>
            </div>
    </div>