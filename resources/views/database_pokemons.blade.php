<!doctype html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Top Index</title>
</head>
<body>
<h1>Top Index</h1>
<a href="{{route('input.pokemon')}}">ポケモン検索ページへ</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>ポケID</th>
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
            <td>{{$pokemon->id}}</td>
            <td>{{$pokemon->pokemons_pokeId}}</td>
            <td>{{$pokemon->pokemons_pokedex_num}}</td>
            <td>{{$pokemon->pokemons_name}}</td>
            <td>{{$pokemon->pokemons_type1}}</td>
            <td>{{$pokemon->pokemons_type2 ?? 'なし'}}</td>
            <td>{{$pokemon->pokemons_form ?? 'なし'}}</td>
            <td><img src="{{ asset('storage/images/pokemons/'.$pokemon->pokemons_pokeId.'.png') }}"></td>
            <td>{{$pokemon->created_at}}</td>
            <td>{{$pokemon->updated_at}}</td>
        </tr>
    @endforeach
</table>
{{ $pokemons->links() }}
</body>
</html>
