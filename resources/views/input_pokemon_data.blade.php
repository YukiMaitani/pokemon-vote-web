<!doctype html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>InputPokemonData</title>
</head>
<body>
    <h1>Input Pokemon Data</h1>
    <a href="{{route('top')}}">ポケモントップページへ</a>
    <form action="{{route('input.pokemon')}}">
        <input type="text" name="pokeId" value="@if(isset($pokeId)) {{$pokeId}} @endif">
        <button type="submit">検索</button>
    </form>
    @if(isset($data))
        {{'名前:'.$data[0]['name']}}
        {{'タイプ：'.$data[0]['types'][0]}}
        <img src="{{$data[0]['imageUrl']}}">
    @endif
</body>
</html>
