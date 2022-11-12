<!doctype html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pokemon Detail</title>
</head>
<body>
    <h1>Pokemon Detail</h1>
    <a href="{{route('top')}}">ポケモントップページへ</a>
    <table border="1">
        <tr>
            <th>図鑑No</th>
            <th>名前</th>
            <th>タイプ１</th>
            <th>タイプ２</th>
            <th>フォーム</th>
            <th>画像</th>
        </tr>
        <tr>
            <td align="center">{{$pokemon->pokemons_pokedex_num}}</td>
            <td align="center">{{$pokemon->pokemons_name}}</td>
            <td align="center">{{$pokemon->pokemons_type1}}</td>
            <td align="center">{{$pokemon->pokemons_type2 ?? 'なし'}}</td>
            <td align="center">{{$pokemon->pokemons_form ?? 'なし'}}</td>
            <td align="center"><img src="{{ asset('images/pokemons/'.$pokemon->pokemons_id.'.png') }}"></td>
        </tr>
    </table>
    <form action="{{route('pokemon.vote', ['pokeId' => $pokemon->pokemons_id])}}" method="post">
        @csrf
        @foreach($pokemonTypes as $pokemonType)
            <div class="form-check">
                <input id="{{$pokemonType->name}}" value="{{$pokemonType->value}}" name="pokemon_type" type="radio">
                <label class="form-check-label" for="{{$pokemonType->name}}">{{$pokemonType->label()}}</label>
            </div>
        @endforeach
        <div class="text-right">
            <button type="submit" class="btn btn-danger btn-primary">投票</button>
        </div>
    </form>
</body>
</html>
