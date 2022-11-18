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
    <form action="{{route('top')}}" class="form">
        <input type="search" name="keyword" value="@if(isset($keyword)) {{$keyword}} @endif" placeholder="ポケモンの名前を入力" id="search_box" class="search-box">
        <button type="submit" id="search_button">検索</button>
        <div class="check-box">
            <input type="checkbox" id="isSV" name="isSV" checked>
            <labe for="isSV">SV登場</labe>
        </div>
    </form>
    @if($pokemons->count() !== 0)
    <section class="wrapper">
        @foreach($pokemons as $pokemon)
        <div class="card">
            <div class="card-header">
                <figure class="card-thumbnail"><img src="{{ asset('storage/images/pokemons/'.$pokemon->pokemons_id.'.png') }}" class="card-image"></figure>
            </div>
            <div class="card-body">
                <div class="first">
                    <p>{{$pokemon->pokemons_pokedex_num}}</p>
                </div>
                <h3 class="card-title">{{$pokemon->pokemons_name}}</h3>
                <h4>{{$pokemon->pokemons_form ?? ''}}</h4>
                <div class="type-container">
                    <p>{{$pokemon->pokemons_type1}}</p>
                    <p>{{$pokemon->pokemons_type2 ?? ''}}</p>
                </div>
                <div class="card-footer">
                    <p class="card-btn"> <a href="{{route('pokemon.detail.show', ['pokeId' => $pokemon->pokemons_id])}}" class="btn compact">投票</a></p>
                </div>
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
