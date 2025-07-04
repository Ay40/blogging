@extends("layouts.app")

@section("content")
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-warning">
                <ol>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ol>
            </div>
        @endif

        <form action="{{ url("/articles/{$article->id}") }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- This converts POST to PUT -->

            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $article->title) }}">
            </div>
            
            <div class="mb-3">
                <label>Current Image</label><br>
                @if($article->image != 'default.jpg')
                    <img src="{{ asset('images/'.$article->image) }}" width="150" class="img-thumbnail mb-2">
                @endif
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label>Body</label>
                <textarea name="body" class="form-control">{{ old('body', $article->body) }}</textarea>
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ $category->id == $article->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Tags</label>
                <select name="tags[]" class="form-select" multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}"
                            {{ in_array($tag->id, $article->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Hold Ctrl (Windows) or Command (Mac) to select multiple tags</div>
            </div>

            <input type="submit" class="btn btn-primary" value="Update Article">
        </form>
    </div>
@endsection