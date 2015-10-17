@extends('master')

@section('title', 'Auto Post Group Facebook')

@section('content')


    @if(isset($status))
        <div class="container">
            <div class="row">
                <div class="alert alert-success">
                    Succcess: <strong>{{ $status['success']['count'] }}</strong> group
                </div>
                <div class="alert alert-error">
                    Error:  <strong>{{ $status['error']['count'] }}</strong> groups
                </div>
            </div>
        </div>
    @endif

<div class="container">
    <div class="row">
        {!! Form::open(['route' => 'fb.group', 'method' => 'post']) !!}
            <div class="form-group">
                <label for="link">Link (<span class="required">*</span>)</label>
                <input type="text" class="form-control" id="link" name="link" placeholder="http://fb.com/1234567890">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <input type="text" class="form-control" id="message" name="message" placeholder="Message">
            </div>
            <div class="form-group">
                <label for="message">Tokens List (<span class="required">*</span>) </label>
                <textarea name="token" id="token" cols="30" rows="10" class="form-control" placeholder="Mỗi token mỗi dòng"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Hấp Diêm (^^)</button>
        {!! Form::close() !!}
        <p></p>
        <small>(<span class="required">*</span>) is required field</small>
    </div>
</div>

@endsection