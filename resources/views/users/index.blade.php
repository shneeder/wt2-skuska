@extends('layouts.app')

@section('content')
    <div class="container">
        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ URL::to('user') }}">Používatelia</a>
                <a class="navbar-brand" href="{{ URL::to('user/create') }}">Vytvor používateľa</a>
            </div>
        </nav>
        <h1>Používatelia</h1>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <!-- will be used to show any messages -->
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>Email</td>
                    <td>Meno</td>
                    <td>Adresa</td>
                    <td>Škola</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $key => $value)
                <tr>
                    <td>{{ $value->email }}</td>
                    <td>{{ $value->first_name, $value->last_name }}</td>
                    <td>{{ $value->street, $value->postal_code, $value->town }}</td>
                    <td>{{ $value->school_name, $value->school_address }}</td>
                    <td>
                        <a class="btn btn-small btn-success" href="{{ URL::to('users/' . $value->id) }}">Detail</a>
                        <a class="btn btn-small btn-info" href="{{ URL::to('users/' . $value->id . '/edit') }}">Upraviť</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
