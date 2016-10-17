@extends('layouts.app')

@section('content')
    <div class="links">
        <a href="{{ URL::to('payment') }}">Payment list</a>
        <br />
        <br />
        <br />
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>N°</th>
                <th>bitcoin address</th>
                <th>private key</th>
                <th>email</th>
                <th>name</th>
                <th>created at</th>
                <th>status</th>
            </tr>
            @foreach ($participants as $key=>$address)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $address->bitcoin_address }}</td>
                    <td>
                        @if ($address->private_key == '')
                            <span class="glyphicon glyphicon-minus-sign" aria-hidden=true></span>
                        @else
                            <span class="glyphicon glyphicon-plus-sign" aria-hidden=true></span>
                        @endif
                    </td>
                    <td>{{ $address->email }}</td>
                    <td>{{ $address->name }}</td>
                    <td>{{ $address->created_at }}</td>
                    <td>
                        @if ($address->status == 1)
                            <span class="glyphicon glyphicon-ok-sign text-success" aria-hidden=true></span>
                        @elseif ($address->status == -1)
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