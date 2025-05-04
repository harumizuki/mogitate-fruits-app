<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品一覧</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        .fruit-list {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .fruit-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            width: 200px;
            box-shadow: 2px 2px 6px rgba(0,0,0,0.1);
            text-align: center;
        }
        .fruit-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 4px;
        }
        .fruit-card h2 {
            margin: 10px 0 4px;
            font-size: 1.2em;
        }
        .fruit-card p {
            color: #666;
        }
    </style>
</head>
<body>
    <h1>商品一覧</h1>

<form action="{{ url('/') }}" method="GET" style="margin-bottom: 20px;">
    <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}">
    <select name="sort">
        <option value="">並び替え</option>
        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>価格が安い順</option>
        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>価格が高い順</option>
    </select>
    <button type="submit">検索</button>
    <form action="{{ route('fruit.export') }}" method="GET" style="margin-bottom: 20px;">
    <button type="submit">CSV出力</button>
</form>

</form>



    @if (session('success'))
    <div style="color: green; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

    <div class="fruit-list">
        @foreach ($fruits as $fruit)
            <div class="fruit-card">
                <img src="{{ asset($fruit['image']) }}" alt="{{ $fruit['name'] }}">
                <h2>{{ $fruit['name'] }}</h2>
                <p>¥{{ $fruit['price'] }}</p>
            </div>
        @endforeach
    </div>
</body>
</html>
