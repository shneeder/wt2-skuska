@extends('layouts.app')

@section('content')
    @if (Auth::user()->isAdmin == 1)
    <div class="container">
        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ URL::to('users') }}">Používatelia</a>
                <a class="navbar-brand" href="{{ URL::to('users/create') }}">Vytvor používateľa</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="{{ URL::to('users') }}">Používatelia</a></li>
                <li><a href="{{ URL::to('users/create') }}">Vytvor používateľa</a>
            </ul>
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
    @else
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Dashboard</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            You are not authorized, only Admin can view users!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
