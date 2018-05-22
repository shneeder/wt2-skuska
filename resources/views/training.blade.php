@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h1>Prehľad osobných výkonov</h1></div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <hr>
                        <div id="news-feed" class="col-md-10">
                            <h2>Tréningy používateľa</h2><hr>

                        </div>

                    <table id="myTable">
                        <thead>
                        <tr>
                            <th onclick="sortTable(0, this)" class='sortingHeader'>Prejdené km</th>
                            <th onclick="sortTable(1, this)" class='sortingHeader'>dátum</th>
                            <th onclick="sortTable(2, this)" class='sortingHeader'>čas - začiatok</th>
                            <th onclick="sortTable(3, this)" class='sortingHeader'>čas - koniec</th>
                            <th onclick="sortTable(4, this)" class='sortingHeader'>GPS - začiatok</th>
                            <th onclick="sortTable(5, this)" class='sortingHeader'>GPS - koniec</th>
                            <th onclick="sortTable(6, this)" class='sortingHeader'>Hodnotenie</th>
                            <th onclick="sortTable(7, this)" class='sortingHeader'>Poznámka</th>
                            <th onclick="sortTable(8, this)" class='sortingHeader'>Priemerná rýchlosť (km/h)</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr class='firstLevelSort'>
                                    <td class="km">{{ $row["km"] }}</td>
                                    <td>{{ $row["datum"] }}</td>
                                    <td>{{ $row["start_time"] }}</td>
                                    <td>{{ $row["finish_time"] }}</td>
                                    <td>{{ $row["start_lat"]}}, {{ $row["start_lng"] }}</td>
                                    <td>{{ $row["finish_lat"]}}, {{ $row["finish_lng"] }}</td>
                                    <td>{{ $row["evaluation"] }}</td>
                                    <td>{{ $row["note"] }}</td>
                                    <td>{{ $row["av_speed"] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                        <h5 class="text-center">Priemerná hodnota odbehnutých/odjazdených kilometrov na jeden tréning:
                        </h5>
                            <p id="averagekm" class="text-center" style="font-size: 26px">
                                {{ $avg_km }}
                            </p>
                        <hr>
                            <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection