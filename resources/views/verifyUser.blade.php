<!DOCTYPE html>
<html>
<head>
    <title>Potvrdenie registrácie</title>
</head>

<body>
<h2>Vitaj {{$user['name']}}</h2>
<br/>
Registrovali Ste si nasledujúci e-mail - {{$user['email']}} , Svoju registráciu potvrdíte kliknutím na túto linku -
<br/>
<a href="{{url('user/verify', $user->verifyUser->token)}}">Potvď e-mail</a>
</body>

</html>
