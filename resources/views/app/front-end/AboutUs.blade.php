@vite(['resources/css/app.css', 'resources/js/app.js'])
@extends('app.layout-frontend.master')

@section('content')
<div class="container" style="background-color:#edefca;width:100%">

    <div class="prose max-w-none text-gray-800" >
        {!! $about->content ?? '<p>Content not available yet.</p>' !!}
    </div>
</div>
@endsection
