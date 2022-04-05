<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BuilderResource;
use App\Http\Resources\V1\BuilderCollection;
use App\Http\Requests\V1\StoreBuilderRequest;

class BuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builders = $request->query('includeDivisions') == 'true' ? 
        Builder::with('divisions')->paginate() 
        : Builder::paginate();

        return new BuilderCollection($builders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBuilderRequest $request)
    {
        return new BuilderResource(Builder::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Builder $builder)
    {
        if (request()->query('includeDivisions') == 'true') {
            return new BuilderResource($builder->loadMissing('divisions'));
        }
    
        return new BuilderResource($builder);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBuilderRequest $request, Builder $builder)
    {
        $builder->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
