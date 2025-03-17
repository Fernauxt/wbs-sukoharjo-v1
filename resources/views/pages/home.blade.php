@extends('layouts.main')

@section('title', 'Home')

@section('content')
<section id="hero" class="lg:mt-4">
    @include('sections.hero')
</section>

<section id="how-to" class="lg:mt-4 lg:mx-8 bg-base-200">
    @include('sections.how-to')
</section>

<section id="faq" class="lg:mt-4 lg:mx-8">
    @include('sections.faq')
</section>
@endsection