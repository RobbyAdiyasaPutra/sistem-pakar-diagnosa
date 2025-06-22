<?php

namespace App\Http\Controllers;

use App\Models\Article; // Import the Article model
use App\Models\User;    // Import User model for author relationship
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // To get the authenticated user

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the author to avoid N+1 query problem
        $articles = Article::with('author')->latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // If authors are selected manually, otherwise `Auth::id()` will be used.
         $authors = User::all();

        // Lewatkan variabel 'authors' ke tampilan articles.create
        return view('articles.create', compact('authors'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:articles,title', // Ensure title is unique for slug generation
            'content' => 'required|string',
            'image_url' => 'nullable|url|max:255',
            'tags' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            // 'author_id' will typically be set from the authenticated user
        ]);

        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'image_url' => $request->image_url,
            'tags' => $request->tags,
            'author_id' => Auth::id(), // Automatically set the author to the logged-in user
            'published_at' => $request->published_at ?? now(), // Set publication date, default to now
        ]);

        return redirect()->route('articles.index')->with('success', 'Article created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        // Increment views count (optional)
        $article->increment('views_count');
        $article->load('author'); // Eager load the author for display
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $authors = User::all();
        return view('articles.edit', compact('article', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:articles,title,' . $article->id,
            'content' => 'required|string',
            'image_url' => 'nullable|url|max:255',
            'tags' => 'nullable|string|max:255',
            'author_id' => 'required|exists:users,id',
            'published_at' => 'nullable|date',
        ]);

        $article->update($request->all());

        return redirect()->route('articles.index')->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully!');
    }
}