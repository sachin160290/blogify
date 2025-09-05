<?php
namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()  { $tags = Tag::orderBy('title')->paginate(10); return view('tags.index', compact('tags')); }
    public function create() { return view('tags.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        Tag::create($data);
        return redirect()->route('tags.index')->with('success','Tag created.');
    }

    public function edit(Tag $tag)   { return view('tags.edit', compact('tag')); }
    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $tag->update($data);
        return redirect()->route('tags.index')->with('success','Tag updated.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success','Tag deleted.');
    }
}
