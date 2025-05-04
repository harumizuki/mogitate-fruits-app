<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品登録フォーム</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        form {
            background-color: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 2px 2px 6px rgba(0,0,0,0.1);
            max-width: 400px;
        }
        label {
            display: block;
            margin-top: 16px;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <h1>商品登録フォーム</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('fruit.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">商品名</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">

        <label for="price">価格</label>
        <input type="number" name="price" id="price" value="{{ old('price') }}">

        <label for="image">商品画像</label>
        <input type="file" name="image" id="image">

        <button type="submit">登録する</button>
    </form>
</body>
</html>
