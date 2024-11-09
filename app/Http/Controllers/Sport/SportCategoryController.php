<?php

namespace App\Http\Controllers\Sport;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sport\StoreSportRequest;
use App\Models\Sport\SportCategory;
use Exception;
use Illuminate\Http\Request;

class SportCategoryController extends Controller
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
    public function update(StoreSportRequest $request, SportCategory $category)
    {
        $formData = $request->validated();
        try {
            SportCategory::where('id', $category->id)->update($formData);
            return to_route('sp_categories.show', $category)->with('message', 'Category successfully updated');
        } catch (Exception $e) {
            return to_route('sp_categories.show', $category)->with('message', 'Error(' . $e->getCode() . ') Category can not be updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SportCategory $category)
    {
        /* resticted access - only user who owns the type has access
        if ($category->user_id !== request()->user()->id) {
            abort(403);
        }*/
        try {
            $category->delete();
            return to_route('sp_categories.index')->with('message', 'Category (' . $category->name . ') deleted.');
        } catch (Exception $e) {
            return to_route('sp_categories.index')->with('message', 'Error (' . $e->getCode() . ') Type: ' . $category->name . ' can not be deleted.');
        }
    }
}
