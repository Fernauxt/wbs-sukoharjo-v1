@extends('layouts.main')

@section('title', 'Home')

@section('content')
<section id="hero" class="lg:mt-4">
    @include('sections.hero')
</section>

<section id="cara-pengaduan" class="lg:mt-4">
    @include('sections.how-to')
</section>

<section id="kontak" class="lg:mt-4">
    @include('sections.contacts')
</section>
@endsection