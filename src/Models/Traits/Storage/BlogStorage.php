<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Storage;

use Innoboxrr\LaravelBlog\Models\BlogMeta;

trait BlogStorage
{

    public function createModel($request)
    {
        $blog = $this->create($request->only($this->creatable)); 
        $blog->updateModelMetas($request);
        return $blog;

    }

    public function updateModel($request)
    {
        $this->update($request->only($this->updatable));
        $this->updateModelMetas($request);
        return $this;
    }

    public function updateModelMetas($request)
    {
        $this->update_metas($request, BlogMeta::class, 'blog_id')->updatePayload();
        return $this;
    }

    public function deleteModel()
    {

        $this->delete();

    }

    public function restoreModel()
    {

        $this->restore();

    }

    public function forceDeleteModel()
    {

        abort(403);

        $this->forceDelete();
        
    }

}