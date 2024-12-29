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
        // Remove if laravel-audit is used: $blog->log('created');
    }
 
    /**
     * Handle the Blog "updated" event.
     */
    public function updated(Blog $blog): void
    {
        // Remove if laravel-audit is used: $blog->log('updated');
    }
 
    /**
     * Handle the Blog "deleted" event.
     */
    public function deleted(Blog $blog): void
    {
        // Remove if laravel-audit is used: $blog->log('deleted');
    }
 
    /**
     * Handle the Blog "restored" event.
     */
    public function restored(Blog $blog): void
    {
        // Remove if laravel-audit is used: $blog->log('restored');
    }
 
    /**
     * Handle the Blog "forceDeleted" event.
     */
    public function forceDeleted(Blog $blog): void
    {
        // Remove if laravel-audit is used: $blog->log('forceDeleted');
    }
}