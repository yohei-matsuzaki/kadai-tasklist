<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;    // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            //$tasks = Task::all();
            
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
       //if (\Auth::check()) { // 認証済みの場合
       // メッセージ一覧を取得
        //$tasks = Task::all();
         ];
        }

        // メッセージ一覧ビューでそれを表示
        return view('tasks.index',$data);
        //[
          //  'tasks' => $tasks,
        //]); //
   // }
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create',[
         'task' => $task,
        ]); //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);
        // メッセージを作成　前のバージョン
        //$task = new Task;
        //$task->status = $request->user()->status;//追加
        //$task->content = $request->user()->content;
        //$task->save(); //
        
         // メッセージを作成　新しいバージョン
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->tasks()->create([
          'content' => $request->content,
          'status' => $request->status,
        ]);
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
       
        
        // メッセージ詳細ビューでそれを表示
        if (\Auth::id() === $task->user_id) {
        return view('tasks.show', [
            'task' => $task,
        ]);//
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        // メッセージ編集ビューでそれを表示
        if (\Auth::id() === $task->user_id) {
        return view('tasks.edit', [
            'task' => $task,
        ]); //
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを更新
         if (\Auth::id() === $task->user_id) {
        $task->status = $request->status;    // 追加
        $task->content = $request->content;
        $task->save();
        }
        // トップページへリダイレクトさせる
        return redirect('/');//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを削除
        if (\Auth::id() === $task->user_id) {
        $task->delete();
        }
        // トップページへリダイレクトさせる
        return redirect('/');//
    }
}
