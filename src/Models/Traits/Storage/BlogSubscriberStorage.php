<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Storage;

// use Innoboxrr\LaravelBlog\Models\BlogSubscriberMeta;

trait BlogSubscriberStorage
{

    public function createModel($request)
    {
        $otherData = $request->only($this->creatable);

        unset($otherData['blog_id']);
        unset($otherData['email']);

        $blogSubscriber = $this->updateOrCreate([
            'email' => $request->email,
            'blog_id' => $request->blog_id
        ], $otherData);

        return $blogSubscriber;
    }

    public function updateModel($request)
    {
     
        $this->update($request->only($this->updatable));

        return $this;

    }

    /*
    public function updateModelMetas($request)
    {

        $this->update_metas($request, BlogSubscriberMeta::class, 'blog_subscriber_id')->updatePayload();

        return $this;

    }
    */

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