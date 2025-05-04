<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FruitController extends Controller
{
    public function index(Request $request)
    {
        $defaultFruits = [
            ['name' => 'みかん', 'price' => 100, 'image' => 'images/orange.png'],
            ['name' => 'バナナ', 'price' => 120, 'image' => 'images/banana.png'],
            ['name' => 'ぶどう', 'price' => 200, 'image' => 'images/grapes.png'],
            ['name' => 'キウイ', 'price' => 180, 'image' => 'images/kiwi.png'],
            ['name' => 'メロン', 'price' => 350, 'image' => 'images/melon.png'],
            ['name' => 'マスカット', 'price' => 300, 'image' => 'images/muscat.png'],
            ['name' => 'もも', 'price' => 250, 'image' => 'images/peach.png'],
            ['name' => 'パイナップル', 'price' => 280, 'image' => 'images/pineapple.png'],
            ['name' => 'いちご', 'price' => 220, 'image' => 'images/strawberry.png'],
            ['name' => 'スイカ', 'price' => 400, 'image' => 'images/watermelon.png'],
        ];

        $sessionFruits = session()->get('fruits', []);

        $uploadedFruits = [];
        $storedImages = Storage::files('public/fruits');
        foreach ($storedImages as $path) {
            $filename = basename($path);
            $uploadedFruits[] = [
                'name' => 'アップロード商品',
                'price' => 999,
                'image' => 'storage/fruits/' . $filename,
            ];
        }

        $fruits = array_merge($defaultFruits, $sessionFruits, $uploadedFruits);

        // 検索処理
        $keyword = $request->input('keyword');
        if (!empty($keyword)) {
            $fruits = array_filter($fruits, function ($fruit) use ($keyword) {
                return mb_strpos($fruit['name'], $keyword) !== false;
            });
        }

        // 並び替え処理（検索のあと）
        $sort = $request->input('sort');
        if ($sort === 'asc') {
            usort($fruits, fn($a, $b) => $a['price'] <=> $b['price']);
        } elseif ($sort === 'desc') {
            usort($fruits, fn($a, $b) => $b['price'] <=> $a['price']);
        }

        return view('fruits.index', ['fruits' => $fruits]);
    }

    public function create()
    {
        return view('fruits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'image' => 'required|image|max:2048',
        ]);

        $image = $request->file('image');
        $path = $image->store('fruits', 'public');
        $filename = basename($path);

        $newFruit = [
            'name' => $request->name,
            'price' => $request->price,
            'image' => 'storage/fruits/' . $filename,
        ];

        $fruits = session()->get('fruits', []);
        $fruits[] = $newFruit;
        session()->put('fruits', $fruits);

        \Log::info('商品登録:', $newFruit);

        return redirect('/')->with('success', '商品を登録しました！');
    }

    public function export()
    {
        $fruits = session()->get('fruits', []);

        $response = new StreamedResponse(function () use ($fruits) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['商品名', '価格', '画像ファイル名']);
            foreach ($fruits as $fruit) {
                fputcsv($handle, [$fruit['name'], $fruit['price'], $fruit['image']]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="fruits.csv"');

        return $response;
    }
}
