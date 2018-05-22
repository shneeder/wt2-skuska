@extends('layouts.app')

@section('content')
    <div class="container">
        <script>
            function sendoutNews() {
                $.post("api/campaign",
                    {
                        "title": document.getElementById('m-title').value,
                        "content": document.getElementById('m-message').value
                    },
                    function (data) {
                        document.getElementById('m-title').value = "";
                        document.getElementById('m-message').value = "";
                        //alert(data.title + " " + data.content);
                        var feed = document.getElementById("news-feed");
                        while (feed.firstChild) {
                            feed.removeChild(feed.firstChild);
                        }
                        //<h3> $new["title"]</h3>
                        //<p> $new["content"]</p>
                        //<hr>
                        data.forEach(function(dt) {
                            var titl = document.createElement("h3");
                            titl.innerHTML = dt.title;
                            var cont = document.createElement("p");
                            cont.innerHTML = dt.content;
                            var line = document.createElement("hr");
                            feed.appendChild(titl);
                            feed.appendChild(cont);
                            feed.appendChild(line);
                            window.scrollTo(0,document.body.scrollHeight);
                            //console.log(dt.title + ", "+dt.content);
                        })
                    }).fail(function (err) {
                    console.log(err);
                    alert("Error occured!");
                });
            }
        </script>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h1>Vytváranie aktualít</h1></div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif


                            <h3 class="text-center">Administrátorská správa aktualít</h3>
                            <div class="container">

                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @endif

                                @if ($message = Session::get('error'))
                                    <div class="alert alert-danger alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @endif

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="well well-sm">

                                            <fieldset>
                                                <legend class="text-center">Zadaj novú aktualitu</legend>
                                                <!-- Name input-->
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="name">Nadpis</label>
                                                    <div class="col-md-12 text-center">
                                                        <input id="m-title" name="title" type="text" placeholder="Názov novej aktuality" class="form-control">
                                                    </div>
                                                </div>

                                                <!-- Message body -->
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="message">Your message</label>
                                                    <div class="col-md-12 text-center">
                                                        <textarea class="form-control" id="m-message" name="content" placeholder="Zadajte text aktuality..." rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <!-- Form actions -->
                                                <div class="form-group">
                                                    <div class="col-md-12 text-center">
                                                        <form onsubmit="sendoutNews(); return false;">
                                                            <button type="submit" class="btn btn-primary">Zverejni aktualitu a Odošli Newsletter</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <hr>

                        <hr>
                            <h2>AKTUALITY:</h2><hr>
                            <div id="news-feed">
                                @foreach ($news as $new)
                                    <h3>{{ $new["title"] }}</h3>
                                    <p>{{ $new["content"]  }}</p>
                                    <hr>
                                @endforeach
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection