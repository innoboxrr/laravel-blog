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
        // Remove if laravel-audit is used: $blogPost->log('created');
    }
 
    /**
     * Handle the BlogPost "updated" event.
     */
    public function updated(BlogPost $blogPost): void
    {
        // Remove if laravel-audit is used: $blogPost->log('updated');
    }
 
    /**
     * Handle the BlogPost "deleted" event.
     */
    public function deleted(BlogPost $blogPost): void
    {
        // Remove if laravel-audit is used: $blogPost->log('deleted');
    }
 
    /**
     * Handle the BlogPost "restored" event.
     */
    public function restored(BlogPost $blogPost): void
    {
        // Remove if laravel-audit is used: $blogPost->log('restored');
    }
 
    /**
     * Handle the BlogPost "forceDeleted" event.
     */
    public function forceDeleted(BlogPost $blogPost): void
    {
        // Remove if laravel-audit is used: $blogPost->log('forceDeleted');
    }
}