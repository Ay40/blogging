@extends("layouts.app")

@section("content")
    <div class="contatiner">

        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        {{ $articles->links() }}
        @foreach ($articles as $article)
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <div class="card-subtitle mb-2 text-muted small">
                        {{ $article->created_at }}, Category:<b>{{ $article->category->name }}</b>

                        <div class="mb-2">
                            <strong>Tags:</strong>
                            @foreach ($article->tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <img src="{{ asset('images/' . $article->image) }}" alt="Article Image"
                                class="img-fluid rounded" style="max-height: 200px;">
                        </div>

                    </div>
                    <p class="card-text">{{ $article->body }}</p>
                    <a href="{{ url("/articles/detail/$article->id") }}" class="card-link">View Details</a>
                </div>
            </div>

            
        @endforeach
    </div>
@endsection