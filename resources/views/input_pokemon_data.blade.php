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
        <table border="1">
            <tr>
                <th>図鑑No</th>
                <th>名前</th>
                <th>タイプ１</th>
                <th>タイプ２</th>
                <th>フォーム</th>
                <th>画像</th>
            </tr>
            @foreach($data as $element)
            <tr>
                <td>{{$element['pokeDexNum']}}</td>
                <td>{{$element['name']}}</td>
                <td>{{$element['type1']}}</td>
                <td>{{$element['type2'] ?? 'なし'}}</td>
                <td>{{$element['form'] ?? 'なし'}}</td>
                <td><img src="{{$element['imageUrl']}}"></td>
            </tr>
            @endforeach
        </table>
    @endif
</body>
</html>
