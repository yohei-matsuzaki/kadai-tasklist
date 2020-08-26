@extends('layouts.app')

@section('content')
    @if (Auth::check())
          
                        
                        
                            {{-- ユーザ詳細ページへのリンク --}}
                            <!--<li class="dropdown-item"><a href="tasks/index">Tasklist</a></li>
                            <li class="dropdown-divider"></li>-->
                            <li class="nav-item">{!! link_to_route('tasks.index', 'タスク一覧') !!}</li>
                            
                            {{-- メッセージ作成ページへのリンク --}}
                            <li class="nav-item">{!! link_to_route('tasks.create', 'タスク投稿') !!}</li>
                            
                            {{-- ログアウトへのリンク --}}
                            <li class="nav-item">{!! link_to_route('logout.get', 'Logout') !!}</li>
                           
                        </ul>
                    </li>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Tasklist</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection

