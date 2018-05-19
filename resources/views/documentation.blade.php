@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Technická dokumentácia</div>

                    <div class="card-body">
                        <a href="https://github.com/shneeder/wt2-skuska">GitHub</a><hr>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
