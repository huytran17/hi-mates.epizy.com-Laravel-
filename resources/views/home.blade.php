@extends('layouts.app')
@section('title')
	{{ config('app.name', 'hi-mates') }}
@endsection
@section('content')
<div class="row" id="HomeLayout">
    <nav id="NavLeft">
        <div id="SlideLeft">
            <i class="fal fa-angle-right"></i>
        </div>
        <x-list-team :teams="$teams" />
        <div id="accordionMember" class="accordion"></div>
    </nav>
    <div id="MsgFrame">
    </div>
</div>
@endsection 