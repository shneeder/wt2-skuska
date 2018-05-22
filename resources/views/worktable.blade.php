@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1>Rozdelenie úloh</h1>
                <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Marek Schmidt</th>
                    <th scope="col">Lukas Snider</th>
                    <th scope="col">Kamil Bator</th>
                    <th scope="col">Juraj Bezak</th>
                    <th scope="col">Miroslav Kubus</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td></td>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th scope="row">2 - registrácia</th>
                    <td></td>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th scope="row">2 - load CSV</th>
                    <td></td>
                    <td></td>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th scope="row">4</th>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th scope="row">5</th>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr class="text-white bg-dark">
                    <th scope="row">6</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr class="text-white bg-dark">
                    <th scope="row">7</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th scope="row">8</th>
                    <td></td>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                    <td class="text-center">&#10004; &#42;</td>
                  </tr>
                  <tr>
                    <th scope="row">9</th>
                    <td></td>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                    <td class="text-center">&#10004; &#42;</td>
                  </tr>
                  <tr class="text-white bg-dark">
                    <th scope="row">10</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th scope="row">11</th>
                    <td></td>
                    <td></td>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr class="text-white bg-dark">
                    <th scope="row">12</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th scope="row">13</th>
                    <td></td>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th scope="row">Databáza</th>
                    <td class="text-center">&#10004;</td>
                    <td class="text-center">&#10004;</td>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th scope="row">Celkové spracovanie stránky</th>
                    <td></td>
                    <td class="text-center">&#10004;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
              <i>&#42; súbor infoTrening.php v adresári /public</i><br>
              <p>
                Pri snahe o poskladanie zdrojových kódov od rôznych členov tímu mohlo dôjsť k ich znefunkčneniu,
                preto tu aj uvádzam pôvodné súbory od jednotlivých ľudí:
              <ul>
                <li><strong>Marek Schmidt</strong>: celý adresár /public/wt2</li>
                <li><strong>Kamil Bator</strong>: celý adresár /public/bod11</li>
                <li><strong>Miroslav Kubus</strong>:  /public/infoTrening.php</li>
              </ul>
              </p>
            </div>
        </div>
    </div>
@endsection
