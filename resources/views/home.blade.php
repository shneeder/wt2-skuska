@extends('layouts.app')

@section('content')
    @if (Auth::user()->isAdmin == 1)
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
                            <!-- <a href="wt2-skuska/public/bod11/admin.php">Nacitanie suboru + geocoding</a> -->
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
