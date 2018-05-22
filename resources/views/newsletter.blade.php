@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h1>Odoberanie aktualít</h1></div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ url('subscribe') }}" method="post">
                            <div class="form-group">
                                <label for="exampleInputEmail">E-mail</label>
                                <input type="email" name="user_email" id="exampleInputEmail"
                                       class="form-control" value="{{ Auth::user()->email }}">
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">Prihlásiť sa do Newsletter odberu.</button>
                        </form>
                        <hr>
                        <form action="{{ url('unsubscribe') }}" method="post">
                            <input type="email" name="user_email" id="exampleInputEmail"
                                   class="form-control" value="{{ Auth::user()->email }}" hidden>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">Odhlásiť sa z Newsletter odberu.</button>
                        </form>
                        <hr>
                        <div id="news-feed" class="col-md-10">
                            <h2>AKTUALITY:</h2><hr>
                            <div>
                                @foreach ($news as $new)
                                    <h3>{{ $new["title"] }}</h3>
                                    <p>{{ $new["content"] }}</p>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection