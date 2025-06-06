<?php

namespace Innoboxrr\LaravelBlog\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Innoboxrr\LaravelBlog\Http\Requests\Blog\{
    PoliciesRequest,
    PolicyRequest,
    IndexRequest,
    ShowRequest,
    CreateRequest,
    UpdateRequest,
    DeleteRequest,
    RestoreRequest,
    ForceDeleteRequest,
    ExportRequest,
    LambdaRequest,
    AssetsRequest,
    SubscriberVerifyRequest
};

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'assets']);
    }

    public function policies(PoliciesRequest $request)
    {
        return $request->handle($this);   
    }

    public function policy(PolicyRequest $request)
    {
        return $request->handle();
    }

    public function index(IndexRequest $request)
    {
        return $request->handle();   
    }

    public function show(ShowRequest $request)
    {
        return $request->handle();   
    }

    public function create(CreateRequest $request)
    {
        return $request->handle();   
    }

    public function update(UpdateRequest $request)
    {
        return $request->handle();   
    }

    public function delete(DeleteRequest $request)
    {
        return $request->handle();   
    }

    public function restore(RestoreRequest $request)
    {
        return $request->handle();   
    }

    public function forceDelete(ForceDeleteRequest $request)
    {
        return $request->handle();   
    }

    public function export(ExportRequest $request)
    {
        return $request->handle();   
    }

    public function lambda(LambdaRequest $request)
    {
        return $request->handle();   
    }

    public function assets(AssetsRequest $request)
    {
        return $request->handle();
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->away(request()->header('referer'));
    }   

    public function subscriberVerify(SubscriberVerifyRequest $request)
    {
        return $request->handle();
    }
}