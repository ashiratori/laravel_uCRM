<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//コントローラーからvueに渡すときにinertiaレンダーを使う必要がある
use Inertia\Inertia;
use App\Models\InertiaTest;

class InertiaTestController extends Controller
{
    //ルートからコントローラーに渡り、コントローラーのこのindexメソッドが実行され、
    //InertiaレンダーのIndexが表示されればOK
    //ここにメソッドを記載する
    public function index()
    {
        //下記ではコンポーネントの名前を記載する
        //連想配列でキーとバリューをvueに返すことができる
        return Inertia::render('Inertia/Index', [
            'blogs' => InertiaTest::all()
        ]);
    }
    public function create()
    {
        return Inertia::render('Inertia/Create');
    }    
    public function show($id)
    {
        //コントローラーまではidがわたっていることが確認できた
        //ビューの方に値を持っていきたい
        //returnは連想配列とするキー、バリューの形
        return Inertia::render('Inertia/Show',
        [
            //key,value
            'id' => $id,
            //この関数にidが渡ってきて、1番目なら1、10番目なら10番目の情報を取得して
            //blogという変数でview側に渡すはず
            'blog' => InertiaTest::findOrFail($id)
        ]);
    }
    //inputタグで入力した内容をこのrequest変数で受け取ることができる
    public function store(Request $request)
    {
        //バリデーションチェックを行う
        $request->validate([
            'title' => ['required', 'max:20'],
            'content' => ['required'],
        ]);

        //modelで読み込んでインスタンスを作成している
        $inertiaTest = new InertiaTest;
        $inertiaTest->title = $request->title;
        $inertiaTest->content = $request->content;
        $inertiaTest->save();
        //inertia.indexに飛ばしている
        //DBまでの保存ができたらindexを呼び出している
        //withを追加することでセッションメッセージ（フラッシュメッセージ）を渡すことができる
        return to_route('inertia.index')->with([
            'message' => '登録しました。'
        ]);
    }
    //削除処理
    public function delete($id)
    {
        //下記でid1件だけの情報を指定している
        $book = InertiaTest::findOrFail($id);
        $book->delete();
        //指定された名前付きルートinertia.indexにリダイレクトするためのコード
        return to_route('inertia.index')
        ->with([
            'message' => '削除しました。'
        ]);
    }

}
