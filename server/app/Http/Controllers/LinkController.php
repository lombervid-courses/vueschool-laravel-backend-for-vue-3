<?php

namespace App\Http\Controllers;

use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = QueryBuilder::for(request()->user()->links())
            ->allowedFilters(['full_link', 'short_link'])
            ->allowedSorts(['full_link', 'short_link', 'views', 'id'])
            ->paginate(request('per_page', 5));

        return response()->json($links);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request)
    {
        $link = $request->user()->links()->create($request->validated());

        return response()->json($link, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        return response()->json($link);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLinkRequest $request, Link $link)
    {
        $link->update($request->validated());

        return response()->json($link);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $link->delete();

        return response()->json(status: 204);
    }
}
