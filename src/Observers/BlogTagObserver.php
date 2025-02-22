<?php
 
namespace Innoboxrr\LaravelBlog\Observers;
 
use Innoboxrr\LaravelBlog\Models\BlogTag;
 
class BlogTagObserver
{

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the BlogTag "created" event.
     */
    public function created(BlogTag $blogTag): void
    {
        $blogTag->log('created');
    }
 
    /**
     * Handle the BlogTag "updated" event.
     */
    public function updated(BlogTag $blogTag): void
    {
        $blogTag->log('updated');
    }
 
    /**
     * Handle the BlogTag "deleted" event.
     */
    public function deleted(BlogTag $blogTag): void
    {
        $blogTag->log('deleted');
    }
 
    /**
     * Handle the BlogTag "restored" event.
     */
    public function restored(BlogTag $blogTag): void
    {
        $blogTag->log('restored');
    }
 
    /**
     * Handle the BlogTag "forceDeleted" event.
     */
    public function forceDeleted(BlogTag $blogTag): void
    {
        $blogTag->log('forceDeleted');
    }
}