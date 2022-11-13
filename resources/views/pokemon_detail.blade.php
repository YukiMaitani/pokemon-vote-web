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
            <td align="center"><img src="{{ asset('storage/images/pokemons/'.$pokemon->pokemons_id.'.png') }}"></td>
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
    <div id="chart-type-container" width="200" height="200">
        <canvas id="chart-type"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = [];
        const counts = [];
        const backgroundColors = [];
        const voteCounts = @json($voteCounts);
        for(const label in voteCounts) {
            labels.push(label);
            counts.push(voteCounts[label]['count']);
            backgroundColors.push(voteCounts[label]['rgba']);
        }
        const data = {
            labels: labels,
            datasets: [{
                data: counts,
                backgroundColor:backgroundColors
            }]
        }
        const typeChartCanvas = document.getElementById("chart-type");
        const typeChart = new Chart(typeChartCanvas, {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: '最強のテラスタルはどれ？',
                    }
                }
            }
        });
    </script>
</body>
</html>
