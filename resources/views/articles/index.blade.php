@extends('layouts.app')

@section('title', 'Latest Articles')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <h1 class="h3 mb-0">Latest Articles</h1>
        <div class="w-100" style="max-width: 360px;">
            <label for="article-search" class="visually-hidden">Search by title</label>
            <input type="search" id="article-search" class="form-control" placeholder="Search by title..." autocomplete="off">
        </div>
    </div>

    <p class="text-muted small" id="article-count" aria-live="polite">{{ $articles->count() }} {{ Str::plural('article', $articles->count()) }}</p>

    <div class="row g-4" id="article-list">
        @foreach ($articles as $article)
            <div class="col-md-6 col-lg-4" data-article data-title="{{ Str::lower($article->title) }}">
                <article class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <span class="badge text-bg-primary align-self-start mb-2">{{ $article->category->name }}</span>
                        <h2 class="h5 card-title">
                            <a href="{{ route('articles.show', $article->permalink) }}" class="stretched-link text-decoration-none text-dark">{{ $article->title }}</a>
                        </h2>
                        <p class="card-text text-muted flex-grow-1">{{ $article->summary }}</p>
                        <p class="card-text small text-secondary mb-0">
                            @if ($article->author)
                                {{ $article->author->name }} &middot;
                            @endif
                            <time datetime="{{ $article->published_at->toIso8601String() }}">{{ $article->published_at->format('d M Y') }}</time>
                        </p>
                    </div>
                </article>
            </div>
        @endforeach
    </div>

    <div class="alert alert-secondary text-center mt-4 {{ $articles->isEmpty() ? '' : 'd-none' }}" id="article-empty">
        No articles found.
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            const input = document.getElementById('article-search');
            const items = Array.from(document.querySelectorAll('[data-article]'));
            const empty = document.getElementById('article-empty');
            const counter = document.getElementById('article-count');

            input.addEventListener('input', () => {
                const term = input.value.trim().toLowerCase();
                let visible = 0;

                items.forEach((item) => {
                    const match = item.dataset.title.includes(term);
                    item.classList.toggle('d-none', !match);
                    if (match) visible++;
                });

                empty.classList.toggle('d-none', visible > 0);
                counter.textContent = `${visible} ${visible === 1 ? 'article' : 'articles'}`;
            });
        })();
    </script>
@endpush
