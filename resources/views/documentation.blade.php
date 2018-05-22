@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Technická dokumentácia</div>

                    <div class="card-body">
                        <a href="https://github.com/shneeder/wt2-skuska">GitHub</a><hr>
                        <h4>Prístupné podstránky</h4>
                        <img src="app_diagram.png" alt="Diagram stránky" height="450">
                        <br><hr>
                        <h4>/welcome</h4>
                        <p>Úvodná stránka s tromi linkami pre anonymných pouťívateľov:
                        <ol>
                            <li>/map (Mapa požívateľov):
                                Mapa dát o školách a bydliskách - služba pre všetkých
                                - keď nie je vybraté tlačidlo pri mape(školy/bydliská), tak defaultne sa zobrazia školy
                                inak sa znovu načíta stránka s formou parametra $_GET (na konci linku je ?show=skoly alebo ?show=bydliska)
                            </li>
                            <li>
                                /documentation (Technická dokumentácia)
                            </li>
                            <li>
                                /worktable (Rozdelenie úloh medzi členmi tohto tímu)
                            </li>
                        </ol>
                        </p>
                        <h4>/home</h4>
                        <p>
                            stránku tvoria 3 sekcie:
                        <ol>
                            <li>zoznam trás - užívateľ vidí všetky trasy s označením public alebo private ktoré vytvoril on sám. Ak je prihlásený admin vidí všetky trasy.
                                užívateľ môže z aktivniť trasu kliknutím na tlačidlo aktivuj, zároveň aktívna sa deaktivuje. po opätovnej aktivácii môže užívateľ pokračovať
                                v tréningu. Po kliknutí na jednotlivú trasu sa zobrazí trasa.php.</li>
                            <li>pridaj novu trasu - užívateľ môže pridať novu trasu zadaním súradníc štartu a cieľa a definovaním ci ide o public alebo private trasu.</li>
                            <li>trasy užívateľa - tuto sekciu vidí len admin. po potvrdení užívateľa, admin vidí všetky trasy daného užívateľa.</li>
                        </ol>
                        </p>
                        <h4>/home/active</h4>
                        <p>
                            tato stránka je rozdelená na 4 sekcie:
                        <ol>
                            <li>mapa - zobrazenie vykresľovanie už prejdenej trasy užívateľom</li>
                            <li>tréningy - užívateľ vidí koľko a kedy odbehol danú trasu</li>
                            <li>info o trase - táto čas je needitovateľná a užívateľ tu vidí ako dlhá je trasa, koľko odbehol a koľko km mu ostáva. taktiež sa tu nachádzajú gps súradnice štartu a cieľa.</li>
                            <li>pridaj tréning - užívateľ tu môže zaznamenať tréning</li>
                        </ol>
                        </p>
                        <h4>/home/route</h4>
                        <p>
                            tato stránka je podobná ako aktívna.php užívateľ vidí prvé 3 body mapa, tréningy a info o trase. tato stránka sa zobrazí keď užívateľ klikne v zozname tras na jednotlivú trasu. Nie je možne tu pridať nový tréning.
                        </p>
                        <h4>/admin</h4>
                        <p>
                            Načítanie súboru vo formáte CSV - je potrebné vybrať súbor a následne aj potvrdiť<br>
                            Geocoding <ul> <li> služba pre admina</li>
                            <li> denný limit má 2500 volaní, takže som túto starosť nechal pre administrátora</li>

                            <li> pre každú unikátnu adresu školy a obydlia v tabuľke users sa zavolá geocoding,
                                napr.  $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$urlSkola.'&key=AIzaSyDNR8tp7L03rEX6lCXnoK6DrylRznvGYeY';
                                kde $urlSkola je daná adresa školy z databáze spracovaná funkciou rawurlencode(adresaSkoly);
                            </li>
                            <li> po samotnom stisnutí tlačidla pre geocoding treba čakať na všetky volania geocoding api
                                a aktualizáciu databázy o zemepisné údaje k danej adrese
                            </li>
                        </ul>
                        </p>
                        <h4>/admin</h4>
                        <p>
                            Načítanie súboru vo formáte CSV - je potrebné vybrať súbor a následne aj potvrdiť<br>
                            Geocoding <ul> <li> služba pre admina</li>
                            <li> denný limit má 2500 volaní, takže som túto starosť nechal pre administrátora</li>

                            <li> pre každú unikátnu adresu školy a obydlia v tabuľke users sa zavolá geocoding,
                            napr.  $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$urlSkola.'&key=AIzaSyDNR8tp7L03rEX6lCXnoK6DrylRznvGYeY';
                            kde $urlSkola je daná adresa školy z databáze spracovaná funkciou rawurlencode(adresaSkoly);
                            </li>
                            <li> po samotnom stisnutí tlačidla pre geocoding treba čakať na všetky volania geocoding api
                            a aktualizáciu databázy o zemepisné údaje k danej adrese
                            </li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
