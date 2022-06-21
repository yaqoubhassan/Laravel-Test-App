<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Resources\LinkResource;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = Link::all();
        return LinkResource::collection($links);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'link' => 'required|string',
            'open_in_new_tab' => 'required|boolean'
        ]);

        $link = new Link();
        $link->title = $request->input('title');
        $link->link = $request->input('link');
        $link->open_in_new_tab = $request->input('open_in_new_tab');

        $link->save();

        return new LinkResource($link);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        return new LinkResource($link);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        $this->validate($request, [
            'title' => 'filled|string',
            'link' => 'filled|string',
            'open_in_new_tab' => 'filled|boolean'
        ]);

        $input = $request->only(['title', 'link', 'open_in_new_tab']);
        $link->update($input);

        return new LinkResource($link);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return response()->noContent();
    }
}
