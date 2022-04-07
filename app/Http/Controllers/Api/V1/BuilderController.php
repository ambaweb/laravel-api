<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\V1\Controller;
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

        return (new BuilderCollection($builders))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBuilderRequest $request)
    {
        return (new BuilderResource(Builder::create($request->all())))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
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
            return (new BuilderResource($builder->loadMissing('divisions')))
                ->response()
                ->setStatusCode(Response::HTTP_OK);
        }

        return (new BuilderResource($builder))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
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
        return (new BuilderResource($builder))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
