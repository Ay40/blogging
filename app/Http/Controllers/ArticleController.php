<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Tag;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['category', 'tags'])->latest()->paginate(9);

        return view('articles/index', [
            'articles' => $articles
        ]);
    }

    public function detail($id)
    {
        $data = Article::find($id);
        return view('articles.detail', [
            'article' => $data
        ]);
    }

    public function add()
    {
        $data = [
            ["id" => 1, "name" => "Science"],
            ["id" => 2, "name" => "Technology"],
        ];
        
        return view("articles.add", [
            'categories' => $data
        ]);
    }

    // public function create()
    // {
    //     $validator = validator(request()->all(), [
    //         'title' => 'required',
    //         'body' => 'required',
    //         'category_id' => 'required',
            
    //     ]);

        

    //     if($validator->fails()) {
    //         return back()->withErrors($validator);
    //     }

    //     $article = new Article;
    //     $article->title = request()->title;
    //     $article->body = request()->body;
    //     $article->category_id = request()->category_id;
    //     $article->save();

    //     return redirect('/articles');

    // }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('articles.add', compact('categories', 'tags'));
    }


    public function delete($id)
    {
        $article = Article::find($id);
        $article->delete();

        return redirect('/articles')->with('info', 'Your article is deleted');
    }



// Update the store method
// public function store(Request $request)
// {
//     $request->validate([
//         'title' => 'required|max:255',
//         'body' => 'required',
//         'category_id' => 'required|exists:categories,id',
//         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//         'tags' => 'nullable|string',
//     ]);
//     $imageName = 'default.jpg'; 

//      if ($request->hasFile('image')) {


//         $imageName = time() . '.' . $request->image->extension();
//         $request->image->move(public_path('images'), $imageName);
//     }
    
//     Article::create([
//         'title' => $request->title,
//         'body' => $request->body,
//         'category_id' => $request->category_id,
//         'image' => $imageName,
//     ]);
//     return redirect()->route('articles.index')
//         ->with('success', 'Article created successfully.');
// }


public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'body' => 'required',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'tags' => 'nullable|array',
        'tags.*' => 'exists:tags,id',
    ]);

    $imageName = 'default.jpg';
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
    }

    $article = Article::create([
        'title' => $request->title,
        'body' => $request->body,
        'category_id' => $request->category_id,
        'image' => $imageName,
    ]);

    if ($request->has('tags')) {
        $article->tags()->attach($request->tags);
    }

    return redirect()->route('articles.index')->with('success', 'Article created successfully.');
}


public function edit(Article $article)
{
    $categories = Category::all();
    $tags = Tag::all();
    
    return view('articles.edit', compact('article', 'categories', 'tags'));
}

public function update(Request $request, Article $article)
{
    $request->validate([
        'title' => 'required',
        'body' => 'required',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'tags' => 'nullable|array',
        'tags.*' => 'exists:tags,id',
    ]);

    $imageName = $article->image;
    if ($request->hasFile('image')) {
        // Delete old image if it's not the default
        if ($imageName !== 'default.jpg') {
            $oldImagePath = public_path('images/' . $imageName);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
    }

    $article->update([
        'title' => $request->title,
        'body' => $request->body,
        'category_id' => $request->category_id,
        'image' => $imageName,
    ]);

    // Sync tags
    if ($request->has('tags')) {
        $article->tags()->sync($request->tags);
    } else {
        $article->tags()->detach();
    }

    return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
}


public function destroy(Article $article)
{
    // Detach all tags first
    $article->tags()->detach();

    // First we remove all tag relationships using detach()
    
    // Delete the article image if it's not the default
    if ($article->image != 'default.jpg') {
        $imagePath = public_path('images/' . $article->image);
        if (file_exists($imagePath)) {
            unlink($imagePath); // delete
        }
    }
    
    // Delete the article
    $article->delete();
    
    return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
}

}
