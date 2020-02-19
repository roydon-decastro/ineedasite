<?php

namespace App\Http\Controllers;

use App\Template;
use App\Http\Resources\Template as TemplateResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TemplatesController extends Controller
{
    //
    public function index() {
        // get the templates of the user of the request
        // need to build relationship between user and their templates
        $this->authorize('viewAny', Template::class);
        // OLD
        // return request()->user()->templates;
        // NEW
        return TemplateResource::collection(request()->user()->templates);
    }

    public function store() {
        //OLD
        // Template::create($this->validateData());
        // NEW get user from request, then use user-templates relationship to create/store a template
        // this will create a user_id automatically
        $this->authorize('create', Template::class);
        // OLD
        // request()->user()->templates()->create($this->validateData());
        // NEW
        // when we save, laravel automatically gives back the saved record so we can work on it immediately, you just need to save it into a new variable
        $template = request()->user()->templates()->create($this->validateData());
        // Response Symphony HTTP_CREATED == 201
        return (new TemplateResource($template))->response()->setStatusCode(Response::HTTP_CREATED);

    }
        
    public function show(Template $template)
    {

        // if(request()->user()->isNot($template->user)) {

        //     return response([], 403);
        // }
        $this->authorize('view', $template);
        //OLD
        // return $template;
        //NEW
        return new TemplateResource($template);
    }

    public function update(Template $template) {
        // if(request()->user()->isNot($template->user)) {

        //     return response([], 403);
        // }
        $this->authorize('update', $template);
        $template->update($this->validateData());
        // Response Symphony HTTP_OK == 200
        return (new TemplateResource($template))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Template $template) {
        // if(request()->user()->isNot($template->user)) {

        //     return response([], 403);
        // }
        $this->authorize('delete', $template);
        $template->delete();
        return response([], Response::HTTP_NO_CONTENT);
    }

    private function validateData() {
        return request()->validate([
            'name' => 'required',
            'description' => 'required',
            'photo' => 'required',
            'livedate' => 'required',
            'content' => 'required'
        ]);
    }
}
