@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/twitter.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="twPc-div">
                <a class="twPc-bg twPc-block" style="background-image: url('{{ Session::get('user.profile_banner_url') }}');"></a>

                <div>
                    <a title="{{ Session::get('user.name') }}" href="https://twitter.com/{{ Session::get('user.screen_name') }}" class="twPc-avatarLink">
                        <img alt="{{ Session::get('user.name') }}" src="{{ Session::get('user.profile_image_url') }}" class="twPc-avatarImg">
                    </a>

                    <div class="twPc-divUser">
                        <div class="twPc-divName">
                            <a href="https://twitter.com/{{ Session::get('user.screen_name') }}">{{ Session::get('user.name') }}</a>
                        </div>

                        <span>
                            <a href="https://twitter.com/{{ Session::get('user.screen_name') }}">@<span>{{ Session::get('user.screen_name') }}</span></a>
                        </span>
                    </div>

                    <div class="twPc-divStats">
                        <ul class="twPc-Arrange">
                            <li class="twPc-ArrangeSizeFit">
                                <a href="https://twitter.com/{{ Session::get('user.screen_name') }}" title="{{ number_format(Session::get('user.statuses_count')) }} Tweets">
                                    <span class="twPc-StatLabel twPc-block">Tweets</span>
                                    <span class="twPc-StatValue">{{ number_format(Session::get('user.statuses_count')) }}</span>
                                </a>
                            </li>

                            <li class="twPc-ArrangeSizeFit">
                                <a href="https://twitter.com/{{ Session::get('user.screen_name') }}/following" title="{{ number_format(Session::get('user.friends_count')) }} Following">
                                    <span class="twPc-StatLabel twPc-block">Following</span>
                                    <span class="twPc-StatValue">{{ number_format(Session::get('user.friends_count')) }}</span>
                                </a>
                            </li>

                            <li class="twPc-ArrangeSizeFit">
                                <a href="https://twitter.com/{{ Session::get('user.screen_name') }}/followers" title="{{ number_format(Session::get('user.followers_count')) }} Followers">
                                    <span class="twPc-StatLabel twPc-block">Followers</span>
                                    <span class="twPc-StatValue">{{ number_format(Session::get('user.followers_count')) }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @if ($errors->any())
                <div class="panel panel-danger">
                    <div class="panel-body">
                        <p>Oops...</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="{{ route('tweet') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea name="tweet" class="form-control" placeholder="What's happening?" >{{ old('tweet') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <input type="file" name="files[]" class="form-control" multiple>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary pull-right">Tweet</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Timeline</div>

                <div class="panel-body">
                    <ul class="media-list">
                        @foreach ($tweets as $tweet)
                            <li class="media">
                                <a href="https://twitter.com/{{ $tweet->user['screen_name'] }}" class="pull-left" target="_blank">
                                    <img src="{{ $tweet->user['profile_image_url'] }}" class="img-circle">
                                </a>

                                <div class="media-body">
                                    <span class="text-muted pull-right">
                                        <small class="text-muted">{{ $tweet->created_at }}</small>
                                    </span>

                                    <strong>{{ $tweet->user['name'] }} <small>{{ '@'.$tweet->user['screen_name'] }}</small></strong>

                                    <p>{{ $tweet->text }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
