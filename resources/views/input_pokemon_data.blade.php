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
                <th>タイプ</th>
                <th>フォーム</th>
                <th>画像</th>
            </tr>
            <tr>
                <td>{{$data[0]['pokeDexNum']}}</td>
                <td>{{$data[0]['name']}}</td>
                <td>{{$data[0]['types'][0]}}</td>
                <td>{{isset($data[0]['form']) ? $data[0]['form'] : 'なし'}}</td>
                <td><img src="{{$data[0]['imageUrl']}}"></td>
            </tr>
        </table>
    @endif
</body>
</html>
