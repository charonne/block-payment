@extends('layouts.app')


@section('content')
    @if ($valid == 1)
       <h2>Thank you {{ $address->name }}</h2>
    @elseif ($valid == -1)
       <h2>Sorry, this payment is finished</h2>
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
            {!! Form::open(['url' => '/address/add/' . $idkey]) !!}
                <div class="row text-left">
                    <div class="col-lg-12">
                        {{ Form::label('email', 'E-Mail Address *') }}
                        {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'email@domain.tld')) }}
                    </div>
                </div>
                <div class="row text-left">
                    <div class="col-lg-12">
                        {{ Form::label('name', 'Name *') }}
                        {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Prénom Nom')) }}
                    </div>
                </div>
                <div class="row text-left">
                    <div class="col-lg-12">
                        {{ Form::label('bitcoin_address', 'Bitcoin Address *') }}
                        {{ Form::text('bitcoin_address', null, array('class'=>'form-control', 'placeholder'=>'1DE5gG7suYcBpiAp7wswoWGK6upJ3DqA51')) }}
                    </div>
                </div>
                
                <div class="row text-left">
                    <div class="col-lg-12">
                        <span class="text-danger"><strong>Optional:</strong></span> {{ Form::label('address', 'Bitcoin Private Key') }}
                        {{ Form::text('private_key', null, array('class'=>'form-control', 'placeholder'=>'KwhLFr5sMEiJTMjSH6etJK62dJgaNKsFTZuVoUxUxQaMKFKLPnS8')) }}
                    </div>
                </div>
                <div class="row text-left">
                    <div class="col-lg-12">
                        <br />
                        {{ Form::checkbox('check', '1') }} I certify to have saved the private key. *
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-12">
                        <br />
                        {{ Form::submit('Send', array('class'=>'btn btn-success')) }}
                    </div>
                </div>
                <div class="row text-right">
                    <div class="col-lg-12">
                        <em>* mandatory</em>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    @endif
@endsection