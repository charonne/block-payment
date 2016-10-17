@extends('layouts.app')


@section('content')
    @if ($valid == 1)
        <h2>Thank you: <a href="{{ URL::to('address/' . $payment->id_key) }}">{{ $payment->id_key }}</a></h2>
        <br />
        <div class="links">
            <a href="{{ URL::to('payment') }}">Payments list</a>
        </div>
        <br />
    @else
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="jumbotron padding-10px">
            {!! Form::open(['url' => '/payment/add']) !!}
                {{ Form::token() }}
                <div class="row text-left">
                    <div class="col-lg-12">
                        {{ Form::label('title', 'Title') }}
                        {{ Form::text('title', null, array('class'=>'form-control')) }}
                    </div>
                </div>
                <div class="row text-left">
                    <div class="col-lg-12">
                        {{ Form::label('nb_address', 'Number of addresses') }}
                        {{ Form::number('nb_address', null, array('class'=>'form-control')) }}
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-12">
                        <br />
                        {{ Form::submit('Create', array('class'=>'btn btn-primary')) }}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>title</th>
                <th>id key</th>
                <th>max addresses</th>
                <th>nb participants</th>
                <th>created at</th>
                <th>status</th>
            </tr>
            @foreach ($payments as $payment)
                <tr>
                    <td> {{ $payment->title }}</td>
                    <td><a href="{{ URL::to('address/' . $payment->id_key) }}">{{ $payment->id_key }}</a></td>
                    <td> {{ $payment->nb_address }}</td>
                    <td><a href="{{ URL::to('participants/' . $payment->id_key) }}">{{ $payment->nb_participant }}</a></td>
                    <td>{{ $payment->created_at }}</td>
                    <td>
                        @if ($payment->status == 1)
                            <span class="glyphicon glyphicon-ok-sign text-success" aria-hidden=true></span>
                        @elseif ($payment->status == -1)
                            <span class="glyphicon glyphicon-remove-sign text-danger" aria-hidden=true></span>
                        @else
                            <span class="glyphicon glyphicon-question-sign" aria-hidden=true></span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection