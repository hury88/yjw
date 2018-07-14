@extends('layouts.public')

@section('css')
<link rel="stylesheet" href="/style/css/government.css"/>
@stop
@section('right')
<div class="government-deatil">
    <h1>{{$view->title}}</h1>
    {!! $view->content !!}
</div>
<?php
/*
<a href="{{$view->previousLink}}"><span>上一篇：</span>{{$view->previousTitle}}</a>
<a href="{{$view->nextLink}}"><span>下一篇：</span>{{$view->nextTitle}}</a>
*/?>
@stop

