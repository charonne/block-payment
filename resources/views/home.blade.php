@extends('layouts.app')

@section('content')
    @if (count($errors) > 0)
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    {!! Form::open(['url' => '/address/code']) !!}
        {{ Form::token() }}
        <div class="row text-left">
            <div class="col-lg-6 col-lg-offset-3">
                {{ Form::label('code', 'Code') }}
                {{ Form::text('code', null, array('class'=>'form-control')) }}
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-6 col-lg-offset-3">
                <br />
                {{ Form::submit('Validate', array('class'=>'btn btn-primary')) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection
