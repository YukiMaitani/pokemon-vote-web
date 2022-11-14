<!doctype html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Top Index</title>
    <link rel="stylesheet" href="{{asset('css/top_index.css')}}">
</head>
<body>
    <a href="{{route('input.pokemon')}}">ポケモンDB作成ページへ</a>
    <div></div>
    <a href="{{route('database.pokemons')}}">データベースへ</a>
    <form action="{{route('top')}}">
        <input type="search" name="keyword" value="@if(isset($keyword)) {{$keyword}} @endif" placeholder="ポケモンの名前を入力" id="search_box">
        <button type="submit" id="search_button">検索</button>
    </form>
    @if($pokemons->count() !== 0)
    <section class="wrapper">
        @foreach($pokemons as $pokemon)
        <div class="card-container">
            <div class="card-header">
                <figure class="image"><img src="{{ asset('storage/images/pokemons/'.$pokemon->pokemons_id.'.png') }}"></figure>
            </div>
            <div class="card-body">
                <div class="first">
                    <h3>{{$pokemon->pokemons_pokedex_num}}</h3>
                    <div class="type-container">
                        <p>{{$pokemon->pokemons_type1}}</p>
                        <p>{{$pokemon->pokemons_type2 ?? ''}}</p>
                    </div>
                </div>
                <h1>{{$pokemon->pokemons_name}}</h1>
                <h4>{{$pokemon->pokemons_form ?? ''}}</h4>
                <a href="{{route('pokemon.detail.show', ['pokeId' => $pokemon->pokemons_id])}}" class="btn">投票</a>
            </div>
        </div>
        @endforeach
    </section>
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
