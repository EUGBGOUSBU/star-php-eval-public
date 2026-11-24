@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Articles</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $article->category->name }}</li>
        </ol>
    </nav>

    <article class="bg-white rounded shadow-sm p-4 p-md-5">
        <span class="badge text-bg-primary mb-3">{{ $article->category->name }}</span>
        <h1 class="display-6 fw-bold">{{ $article->title }}</h1>
        <p class="text-secondary">
            @if ($article->author)
                By {{ $article->author->name }} &middot;
            @endif
            <time datetime="{{ $article->published_at->toIso8601String() }}">{{ $article->published_at->format('d M Y, h:i A') }}</time>
        </p>
        <p class="lead border-start border-4 border-primary ps-3">{{ $article->summary }}</p>
        <hr>
        @foreach (preg_split('/\R{2,}/', trim($article->body)) as $paragraph)
            <p>{{ $paragraph }}</p>
        @endforeach
    </article>

    <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary mt-4">&larr; Back to articles</a>
@endsection
