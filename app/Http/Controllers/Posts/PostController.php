<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Hashtag;
use App\Models\Post;
use App\Traits\RelationshipsManager;
use Illuminate\Http\Request;

class PostController extends Controller
{

    use RelationshipsManager;

    public function filter(Request $request)
    {
        $query = Post::query();

        $query = $this->setFilters(
            $query,
            $request->search,
            ['title', 'body', 'author', 'status'],
            ['LIKE', 'LIKE', 'LIKE', 'LIKE'],
            [],
            [[]]
        );

        if ($request->status !== null)
            $query->where('status', '=', $request->status);
        else
            $query->where('status', '=', true);
        $posts = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_page'));

        return $posts;
    }

    public function getFilteredByHashtags(Request $request, $name)
    {
        $hashtag = Hashtag::where('name' , '=', $name)->first();
        $posts = Post::whereIn('hashtagIds', [$hashtag->_id])->get();
        return $posts;
    }

    public function all()
    {
        return response()->json(Post::all());
    }

    public function store(PostRequest $request)
    {
        $values = $request->validated();

        if (!key_exists("status", $values) || !$values["status"])
            $values["status"] = false;
        $values["author"] = "Brian Fox";

        $post = Post::create($values);

        return response()->json($post, 201);
    }

    public function show($id)
    {
        return Post::find($id);
    }

    public function update(PostRequest $request, Post $post)
    {
        $values = $request->validated();

        if (!key_exists("status", $values) || !$values["status"])
            $values["status"] = false;
        $values["author"] = "Brian Fox";

        $post->fill($values);
        $post->save();

        return response()->json($post, 201);
    }

    public function destroy(Post $post)
    {
        try{
             $post->delete();
        } catch (\Exception $exception) {
            return response('Can\'t delete post', 500);
        }

        return response('Deleted', 204);
    }
}
