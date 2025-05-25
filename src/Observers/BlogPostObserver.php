<?php
 
namespace Innoboxrr\LaravelBlog\Observers;
 
use Innoboxrr\LaravelBlog\Models\BlogPost;
 
class BlogPostObserver
{

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the BlogPost "created" event.
     */
    public function created(BlogPost $blogPost): void
    {
        $blogPost->log('created');
        $blogPost->blog->clearCache();
    }
 
    /**
     * Handle the BlogPost "updated" event.
     */
    public function updated(BlogPost $blogPost): void
    {
        $blogPost->log('updated');
        $blogPost->blog->clearCache();
    }
 
    /**
     * Handle the BlogPost "deleted" event.
     */
    public function deleted(BlogPost $blogPost): void
    {
        $blogPost->log('deleted');
        $blogPost->blog->clearCache();
    }
 
    /**
     * Handle the BlogPost "restored" event.
     */
    public function restored(BlogPost $blogPost): void
    {
        $blogPost->log('restored');
        $blogPost->blog->clearCache();
    }
 
    /**
     * Handle the BlogPost "forceDeleted" event.
     */
    public function forceDeleted(BlogPost $blogPost): void
    {
        $blogPost->log('forceDeleted');
        $blogPost->blog->clearCache();
    }
}