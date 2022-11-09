<!doctype html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pokemon　DB</title>
</head>
<body>
<h1>Pokemon　DB</h1>
<a href="{{route('top')}}">ポケモントップページへ</a>
<div></div>
<a href="{{route('input.pokemon')}}">ポケモンDB作成ページへ</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>図鑑No</th>
        <th>名前</th>
        <th>タイプ１</th>
        <th>タイプ２</th>
        <th>フォーム</th>
        <th>画像</th>
        <th>作成日</th>
        <th>更新日</th>
    </tr>
    @foreach($pokemons as $pokemon)
        <tr>
            <td align="center">{{$pokemon->pokemons_id}}</td>
            <td align="center">{{$pokemon->pokemons_pokedex_num}}</td>
            <td align="center">{{$pokemon->pokemons_name}}</td>
            <td align="center">{{$pokemon->pokemons_type1}}</td>
            <td align="center">{{$pokemon->pokemons_type2 ?? 'なし'}}</td>
            <td align="center">{{$pokemon->pokemons_form ?? 'なし'}}</td>
            <td align="center"><img src="{{ asset('storage/images/pokemons/'.$pokemon->pokemons_id.'.png') }}"></td>
            <td align="center">{{$pokemon->created_at}}</td>
            <td align="center">{{$pokemon->updated_at}}</td>
        </tr>
    @endforeach
</table>
{{ $pokemons->links() }}
</body>
</html>
