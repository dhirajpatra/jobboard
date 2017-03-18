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
            <div class="alert alert-success"> {{ $success }} </div>
        @endif
        <div class="page-header">&nbsp;</div>
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <h1>Job Posting</h1>


            {{ Form::open(['route' => 'jobpost_post', 'class' => 'form']) }}

            <!-- if there are login errors, show them here -->

                <div class="form-group">
                    {{ Form::label('job_posting_title', 'Title') }}
                    {{ Form::text('job_posting_title', Input::old('job_posting_title'), array('required', 'placeholder' => 'job title')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('job_posting_description', 'Description') }}
                    {{ Form::textarea('job_posting_description', Input::old('job_posting_description'), array('required', 'placeholder' => 'job details')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('job_posting_email', 'email') }}
                    {{ Form::text('job_posting_email', Input::old('job_posting_email'), array('required', 'placeholder' => 'job contact email')) }}
                </div>

                <div class="form-group">
                    {{ Form::submit('Submit') }}
                </div>
                {{ Form::close() }}

                @stop
            </div>
        </div>
    </div>