<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class BlogApiController extends Controller
{
    /**
     * GET /api/get_blogs
     * Query params:
     *  - offset (int) default 0
     *  - limit (int) default 100 (max 100)
     *  - q (string) optional search
     *  - category (id) optional filter by category id
     *  - tag (id) optional filter by tag id
     *
     * Returns list of published blogs (status=published and publish_at <= now)
     */
    public function index(Request $request)
    {
        $offset = max(0, (int) $request->query('offset', 0));
        $limit = min(100, max(1, (int) $request->query('limit', 100)));

        $query = Blog::with(['author:id,name','categories:id,title','tags:id,title'])
            ->where('status', 'published')
            ->where('publish_at', '<=', Carbon::now())
            ->orderByDesc('publish_at');

        if ($q = $request->query('q')) {
            $query->where('title', 'like', "%{$q}%");
        }

        if ($category = $request->query('category')) {
            $query->whereHas('categories', function ($qb) use ($category) {
                $qb->where('categories.id', $category);
            });
        }

        if ($tag = $request->query('tag')) {
            $query->whereHas('tags', function ($qb) use ($tag) {
                $qb->where('tags.id', $tag);
            });
        }

        $total = $query->count();
        $blogs = $query->skip($offset)->take($limit)->get()
            ->map(function ($b) {
                return [
                    'id' => $b->id,
                    'title' => $b->title,
                    'description' => $b->description,
                    'author' => $b->author ? ['id'=>$b->author->id,'name'=>$b->author->name] : null,
                    'publish_at' => $b->publish_at,
                    'time_to_read' => $b->time_to_read,
                    'categories' => $b->categories->map(fn($c)=>['id'=>$c->id,'title'=>$c->title]),
                    'tags' => $b->tags->map(fn($t)=>['id'=>$t->id,'title'=>$t->title]),
                    'status' => $b->status,
                ];
            });

        return response()->json([
            'data' => $blogs,
            'meta' => [
                'total' => $total,
                'offset' => $offset,
                'limit' => $limit,
            ],
        ]);
    }

    /**
     * POST /api/add_new_blog
     * Auth required. Role-based check (admin/editor allowed to create).
     * Body: title, description, author_id, publish_at, time_to_read, status, categories (array of ids), tags (array of ids)
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // role check: admin or editor can create
        if (!in_array($user->role, ['admin','editor'])) {
            return response()->json(['message'=>'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author_id' => 'required|exists:users,id',
            'publish_at' => 'required|date',
            'time_to_read' => 'nullable|integer|min:1',
            'status' => ['required', Rule::in(['draft','private','published'])],
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $data = $validator->validated();

        $blog = Blog::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'author_id' => $data['author_id'],
            'publish_at' => Carbon::parse($data['publish_at']),
            'time_to_read' => $data['time_to_read'] ?? 5,
            'status' => $data['status'],
        ]);

        if (!empty($data['categories'])) {
            $blog->categories()->sync($data['categories']);
        }

        if (!empty($data['tags'])) {
            $blog->tags()->sync($data['tags']);
        }

        return response()->json(['message'=>'Blog created','blog_id'=>$blog->id], 201);
    }

    /**
     * PUT /api/update_blog/{id}
     * Auth required. Only admin OR author of blog OR editor allowed to update (you said editor can add/delete; here we allow editors too if desired — adjust as needed)
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message'=>'Not found'], 404);
        }

        // Authorization: admin can update any; editor maybe only own posts or allowed per your policy.
        if ($user->role !== 'admin' && $user->role !== 'editor' && $user->id !== $blog->author_id) {
            return response()->json(['message'=>'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'author_id' => 'sometimes|required|exists:users,id',
            'publish_at' => 'sometimes|required|date',
            'time_to_read' => 'sometimes|nullable|integer|min:1',
            'status' => ['sometimes','required', Rule::in(['draft','private','published'])],
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $data = $validator->validated();

        $blog->fill([
            'title' => $data['title'] ?? $blog->title,
            'description' => array_key_exists('description',$data) ? $data['description'] : $blog->description,
            'author_id' => $data['author_id'] ?? $blog->author_id,
            'publish_at' => isset($data['publish_at']) ? Carbon::parse($data['publish_at']) : $blog->publish_at,
            'time_to_read' => $data['time_to_read'] ?? $blog->time_to_read,
            'status' => $data['status'] ?? $blog->status,
        ]);
        $blog->save();

        if (array_key_exists('categories', $data)) {
            $blog->categories()->sync($data['categories'] ?? []);
        }

        if (array_key_exists('tags', $data)) {
            $blog->tags()->sync($data['tags'] ?? []);
        }

        return response()->json(['message'=>'Blog updated','blog_id'=>$blog->id]);
    }

    /**
     * DELETE /api/delete_blog/{id}
     * Auth required. Admin or editor (subject to your policy)
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message'=>'Not found'], 404);
        }

        if ($user->role !== 'admin' && $user->role !== 'editor' && $user->id !== $blog->author_id) {
            return response()->json(['message'=>'Forbidden'], 403);
        }

        $blog->delete();
        return response()->json(['message'=>'Blog deleted']);
    }

    /**
     * GET /api/get_categories
     * Return all categories (paginated optional)
     */
    public function categories(Request $request)
    {
        $perPage = min(100, max(1, (int)$request->query('limit', 100)));
        $categories = Category::orderBy('title')->paginate($perPage);
        return response()->json($categories);
    }
}
