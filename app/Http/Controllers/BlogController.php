<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    // List with pagination (10 per page)
    public function index()
    {
        $blogs = Blog::with(['author','categories','tags'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('blogs.index', compact('blogs'));
    }

    public function create()
    {
        // Editor is allowed to create
        if (Auth::user()->role === 'editor' || Auth::user()->role === 'admin') {
            $categories = Category::orderBy('title')->get();
            $tags = Tag::orderBy('title')->get();
            return view('blogs.create', compact('categories','tags'));
        }
        abort(403);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'editor') abort(403);

        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'publish_at'   => 'required|date',
            'time_to_read' => 'required|integer|min:1',
            'status'       => 'required|in:draft,private,published',
            'categories'   => 'array',
            'categories.*' => 'exists:categories,id',
            'tags'         => 'array',
            'tags.*'       => 'exists:tags,id',
        ]);

        $data['author_id'] = Auth::id();
        $blog = Blog::create($data);

        $blog->categories()->sync($request->input('categories', []));
        $blog->tags()->sync($request->input('tags', []));

        return redirect()->route('blogs.index')->with('success', 'Blog created.');
    }

    public function edit(Blog $blog)
    {
        // Editors *cannot edit* (only add/delete per your rule)
        if (Auth::user()->role === 'editor') abort(403);

        $categories = Category::orderBy('title')->get();
        $tags = Tag::orderBy('title')->get();
        return view('blogs.edit', compact('blog','categories','tags'));
    }

    public function update(Request $request, Blog $blog)
    {
        if (Auth::user()->role === 'editor') abort(403);

        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'publish_at'   => 'required|date',
            'time_to_read' => 'required|integer|min:1',
            'status'       => 'required|in:draft,private,published',
            'categories'   => 'array',
            'categories.*' => 'exists:categories,id',
            'tags'         => 'array',
            'tags.*'       => 'exists:tags,id',
        ]);

        $blog->update($data);
        $blog->categories()->sync($request->input('categories', []));
        $blog->tags()->sync($request->input('tags', []));

        return redirect()->route('blogs.index')->with('success', 'Blog updated.');
    }

    public function destroy(Blog $blog)
    {
        // Editor is allowed to delete
        if (!in_array(Auth::user()->role, ['admin','editor'], true)) abort(403);

        $blog->delete();
        return back()->with('success', 'Blog deleted.');
    }

    // Public listing (frontend) with visibility rule + pagination 10
    public function publicIndex()
    {
        $blogs = Blog::visible()
            ->with(['author','categories','tags'])
            ->orderByDesc('publish_at')
            ->paginate(10);

        return view('public.blogs.index', compact('blogs'));
    }
}
