<?php

namespace App\Http\Controllers;

use App\Models\HTMLSnippet;
use Illuminate\Http\Request;
use App\Http\Resources\HTMLSnippetResource;

class HTMLSnippetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $snippets = HTMLSnippet::all();
        return HTMLSnippetResource::collection($snippets);
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
            'description' => 'required|string',
            'snippet' => 'required|string'
        ]);

        $htmlSnippet = new HTMLSnippet();
        $htmlSnippet->title = $request->input('title');
        $htmlSnippet->description = $request->input('description');
        $htmlSnippet->snippet = $request->input('snippet');
        $htmlSnippet->save();

        return new HTMLSnippetResource($htmlSnippet);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HTMLSnippet $htmlSnippet)
    {
        return new HTMLSnippetResource($htmlSnippet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HTMLSnippet $htmlSnippet)
    {
        $this->validate($request, [
            'title' => 'filled|string',
            'description' => 'filled|string',
            'snippet' => 'filled|string'
        ]);

        $input = $request->only(['title', 'description', 'snippet']);
        $htmlSnippet->update($input);

        return new HTMLSnippetResource($htmlSnippet);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HTMLSnippet $htmlSnippet)
    {
        $htmlSnippet->delete();
        return response()->noContent();
    }
}
