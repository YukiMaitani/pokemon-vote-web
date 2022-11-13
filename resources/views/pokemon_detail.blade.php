<!doctype html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pokemon Detail</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
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
    <script>
        const labels = [];
        const counts = [];
        const backgroundColors = [];
        const voteCounts = @json($voteCounts);
        const voteCountsValue = Object.values(voteCounts);
        let voteTotal = voteCountsValue.reduce(function (sum, element){
            console.log(element);
            return sum + element['count'];
        },0);
        for(const label in voteCounts) {
            let voteRate = voteCounts[label]['count']/voteTotal;
            if(voteRate === 0) continue;
            labels.push(label);
            counts.push(voteRate);
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
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: '最強のテラスタルはどれ？',
                    },
                    datalabels: {
                        color: 'white',
                        formatter: (value, context) => {
                            const label = context.chart.data.labels[context.dataIndex];
                            return label + '\n' + Math.round(value*100) + '%';
                        },
                        display: 'auto'
                    }
                }
            }
        });
    </script>
</body>
</html>
