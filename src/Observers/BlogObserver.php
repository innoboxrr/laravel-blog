<?php
 
namespace Innoboxrr\LaravelBlog\Observers;
 
use Innoboxrr\LaravelBlog\Models\Blog;
 
class BlogObserver
{

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the Blog "created" event.
     */
    public function created(Blog $blog): void
    {
        $blog->log('created');
        $blog->clearCache();
    }
 
    /**
     * Handle the Blog "updated" event.
     */
    public function updated(Blog $blog): void
    {
        $blog->log('updated');
        $blog->clearCache();
    }
 
    /**
     * Handle the Blog "deleted" event.
     */
    public function deleted(Blog $blog): void
    {
        $blog->log('deleted');
        $blog->clearCache();
    }
 
    /**
     * Handle the Blog "restored" event.
     */
    public function restored(Blog $blog): void
    {
        $blog->log('restored');
        $blog->clearCache();
    }
 
    /**
     * Handle the Blog "forceDeleted" event.
     */
    public function forceDeleted(Blog $blog): void
    {
        $blog->log('forceDeleted');
        $blog->clearCache();
    }
}