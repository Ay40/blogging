@extends("layouts.app")

@section("content")
    <div class="container">
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">{{ $article->title }}</h5>
                <div class="card-subtitle mb-2 text-muted small">
                    {{ $article->created_at }}, Category:<b> {{ $article->category->name }} </b>
                </div>

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

                <p class="card-text">{{ $article->body }}</p>
                
                <!-- Action Buttons -->
                <div class="btn-group" role="group">
                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary">Edit</a>
                    {{-- <a href="{{ url("/articles/delete/$article->id") }}" class="btn btn-warning">Delete</a> --}}

                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection