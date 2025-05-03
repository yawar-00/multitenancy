@vite(['resources/css/app.css', 'resources/js/app.js'])
@extends('app.layout-frontend.master')

@section('content')
<div class="container" style="background-color:#edefca;width:100%">

    @if ($about && $about->image)
        <img src="{{ asset('storage/' . $about->image) }}" alt="About Image" class="w-full rounded-lg mb-6 shadow">
    @endif

    <div class="prose max-w-none text-gray-800" >
        {!! $about->content ?? '<p>Content not available yet.</p>' !!}
    </div>
</div>
@endsection
