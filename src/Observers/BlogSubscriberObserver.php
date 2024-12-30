<?php
 
namespace Innoboxrr\LaravelBlog\Observers;
 
use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
 
class BlogSubscriberObserver
{

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the BlogSubscriber "created" event.
     */
    public function created(BlogSubscriber $blogSubscriber): void
    {
        // Remove if laravel-audit is used: $blogSubscriber->log('created');
    }
 
    /**
     * Handle the BlogSubscriber "updated" event.
     */
    public function updated(BlogSubscriber $blogSubscriber): void
    {
        // Remove if laravel-audit is used: $blogSubscriber->log('updated');
    }
 
    /**
     * Handle the BlogSubscriber "deleted" event.
     */
    public function deleted(BlogSubscriber $blogSubscriber): void
    {
        // Remove if laravel-audit is used: $blogSubscriber->log('deleted');
    }
 
    /**
     * Handle the BlogSubscriber "restored" event.
     */
    public function restored(BlogSubscriber $blogSubscriber): void
    {
        // Remove if laravel-audit is used: $blogSubscriber->log('restored');
    }
 
    /**
     * Handle the BlogSubscriber "forceDeleted" event.
     */
    public function forceDeleted(BlogSubscriber $blogSubscriber): void
    {
        // Remove if laravel-audit is used: $blogSubscriber->log('forceDeleted');
    }
}