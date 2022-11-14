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
    <p><a href="{{$yakkunUrl}}" target="_blank" rel="noopener noreferrer">{{$pokemon->pokemons_name}}に関する詳しい情報（ポケモン徹底攻略様より）</a></p>
    <div id="chart-stat-container" width="150" height="200">
        <canvas id="chart-stat"></canvas>
    </div>
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
    @if(isset($voteCounts))
        <div id="chart-type-container" width="200" height="200">
            <canvas id="chart-type"></canvas>
        </div>
    @else
        <p style="color: indianred">まだ投票がありません。</p>
    @endif
    @if(isset($voteCounts))
    <script>
        const voteLabels = [];
        const counts = [];
        const backgroundColors = [];
        const voteCounts = @json($voteCounts);
        const voteCountsValue = Object.values(voteCounts);
        let voteTotal = voteCountsValue.reduce(function (sum, element){ return sum + element['count']; },0);
        for(const label in voteCounts) {
            let voteRate = voteCounts[label]['count']/voteTotal;
            if(voteRate === 0) continue;
            voteLabels.push(label);
            counts.push(voteRate);
            backgroundColors.push(voteCounts[label]['rgba']);
        }
        const data = {
            labels: voteLabels,
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
    @endif
    <script>
        let statsData = @json($pokemon->pokemons_base_stats);
        let stats = JSON.parse(statsData);
        let statLabels = ['HP','こうげき','ぼうぎょ','とくこう','とくぼう','すばやさ'];
        const statValues = [];
        for(var i=0; i<6; i++) {
            let key = statLabels[i]
            let stat = stats[i][key];
            statValues.push(stat);
        }
        const statData = {
            labels: statLabels,
            datasets: [{
                axis: 'y',
                label: '種族値',
                data: statValues,
                fill: false,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)'
                ],
                borderWidth: 3
            }]
        };
        const statChartCanvas = document.getElementById("chart-stat");
        const statChart = new Chart(statChartCanvas,{
            type: 'bar',
            data: statData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                datasets: [{
                    bar:{
                        backgroundColors: 'rgba(255, 159, 64, 1)'
                    }
                }]
            }
        })
    </script>
</body>
</html>
