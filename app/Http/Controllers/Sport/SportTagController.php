<?php

namespace App\Http\Controllers\Sport;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sport\StoreTagRequest;
use App\Models\Sport\SportTag;
use Exception;
use Illuminate\Http\Request;

class SportTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(StoreTagRequest $request, SportTag $tag)
    {
        $formData = $request->validated();
        try {
            SportTag::where('id', $tag->id)->update($formData);
            return to_route('sp_tags.show', $tag)->with('message', 'Tag successfully updated');
        } catch (Exception $e) {
            return to_route('sp_tags.show', $tag)->with('message', 'Error(' . $e->getCode() . ') Tag can not be updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SportTag $tag)
    {
        /* resticted access - only user who owns the type has access
        if ($tag->user_id !== request()->user()->id) {
            abort(403);
        }*/
        try {
            $tag->delete();
            return to_route('sp_tags.index')->with('message', 'Tag (' . $tag->name . ') deleted.');
        } catch (Exception $e) {
            return to_route('sp_tags.index')->with('message', 'Error (' . $e->getCode() . ') Type: ' . $tag->name . ' can not be deleted.');
        }
    }
}
