@extends('layouts.app')

@section('content')
    @if (Auth::user()->isAdmin == 1)
    <div class="container">
        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ URL::to('api/users') }}">Používatelia</a>
                <a class="navbar-brand" href="{{ URL::to('api/users/create') }}">Vytvor používateľa</a>
            </div>
        </nav>
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
                            ADMIN !!!, You are logged in!
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

                            Hello, You are logged in!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
