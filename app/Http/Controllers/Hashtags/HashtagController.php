<?php

namespace App\Http\Controllers\Hashtags;

use App\Http\Controllers\Controller;
use App\Http\Requests\HashtagRequest;
use App\Models\Hashtag;
use App\Traits\RelationshipsManager;
use Illuminate\Http\Request;

class HashtagController extends Controller
{

    use RelationshipsManager;

    public function filter(Request $request)
    {
        $this->authorize('read-hashtags');

        $query = Hashtag::query();

        $query = $this->setFilters(
            $query,
            $request->search,
            ['name'],
            ['LIKE'],
            [],
            [[]]
        );

        $hashtags = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_page'));

        return $hashtags;
    }

    public function all()
    {
        return response()->json(Hashtag::all());
    }

    public function store(HashtagRequest $request)
    {
        $values = $request->validated();

        $hashtag = Hashtag::create($values);

        return response()->json($hashtag, 200);
    }

    public function show($id)
    {
        return Hashtag::find($id);
    }

    public function update(HashtagRequest $request, Hashtag $hashtag)
    {
        $values = $request->validated();

        $hashtag->fill($values);
        $hashtag->save();

        return response()->json($hashtag, 201);
    }

    public function destroy(Hashtag $hashtag)
    {
        try{
             $hashtag->delete();
        } catch (\Exception $exception) {
            return response('Can\'t delete hashtag', 500);
        }

        return response("", 204);
    }
}
