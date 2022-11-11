<!doctype html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Top Index</title>
    <link rel="stylesheet" href="{{asset('storage/css/top_index.css')}}">
</head>
<body>
    <h1>Top Index</h1>
    <a href="{{route('input.pokemon')}}">ポケモンDB作成ページへ</a>
    <div></div>
    <a href="{{route('database.pokemons')}}">データベースへ</a>
    <form action="{{route('top')}}">
        <input type="search" name="keyword" value="@if(isset($keyword)) {{$keyword}} @endif" placeholder="ポケモンの名前を入力" id="search_box">
        <button type="submit" id="search_button">検索</button>
    </form>
    @if($pokemons->count() !== 0)
    <table border="1">
        <tr>
            <th>図鑑No</th>
            <th>名前</th>
            <th>タイプ１</th>
            <th>タイプ２</th>
            <th>フォーム</th>
            <th>画像</th>
            <th>投票ボタン</th>
        </tr>
        @foreach($pokemons as $pokemon)
        <tr>
            <td align="center">{{$pokemon->pokemons_pokedex_num}}</td>
            <td align="center">{{$pokemon->pokemons_name}}</td>
            <td align="center">{{$pokemon->pokemons_type1}}</td>
            <td align="center">{{$pokemon->pokemons_type2 ?? 'なし'}}</td>
            <td align="center">{{$pokemon->pokemons_form ?? 'なし'}}</td>
            <td align="center"><img src="{{ asset('storage/images/pokemons/'.$pokemon->pokemons_id.'.png') }}"></td>
            <td align="center"><a href="{{route('pokemon.detail.show', ['pokeId' => $pokemon->pokemons_id])}}" class="btn">投票</a></td>
        </tr>
        @endforeach
    </table>
    {{ $pokemons->links() }}
    @else
        <p style="color: red">ポケモンが見つかりませんでした。他の条件で検索して下さい。</p>
    @endif
</body>
<script>
    var input = document.getElementById('search_box');
    var value = input.getAttribute('value');
</script>
</html>
