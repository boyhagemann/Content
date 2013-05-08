<?php

namespace Boyhagemann\Content\Controller;

use Boyhagemann\Content\Model\Model;
use App, View, Input, Redirect, Validator;

class CrudController extends \BaseController {

    /**
     *
     * @var string
     */
    protected $modelClass;
    
    /**
     * Model Repository
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $model = Model::where('class', '=', $this->modelClass)->get()->first();
        $records = App::make($model->class)->get();
        return View::make('content::crud.index', compact('model', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function content($id)
    {
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
    }
    
}