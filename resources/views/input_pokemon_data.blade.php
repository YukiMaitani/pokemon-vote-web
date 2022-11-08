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
        <input type="text" name="pokeId">
        <button type="submit">検索</button>
    </form>
    @if(isset($data))
        <form action="{{route('input.pokemon.create')}}" method="post">
            @csrf
            <p>ポケモンID</p>
            <input type="text" value="{{$data[0]['pokeId']}}" name="pokeId">
            <p>図鑑No</p>
            <input type="text" value="{{$data[0]['pokeDexNum']}}" name="pokeDexNum">
            <p>名前</p>
            <input type="text" value="{{$data[0]['name']}}" name="name">
            <p>タイプ１</p>
            <input type="text" value="{{$data[0]['type1']}}" name="type1">
            <p>タイプ２</p>
            <input type="text" value="{{$data[0]['type2']}}" name="type2">
            <p>フォーム</p>
            <input type="text" value="{{$data[0]['form']}}" name="form">
            <p>画像</p>
            <input type="text" value="{{$data[0]['imageUrl']}}" name="imageUrl">
            <div><img src="{{$data[0]['imageUrl']}}"></div>
            <button type="submit">送信</button>
        </form>
    @endif
</body>
</html>
