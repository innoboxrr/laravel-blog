<?php

namespace Innoboxrr\LaravelBlog\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Innoboxrr\LaravelBlog\Tests\TestCase;

class BlogSubscriberEndpointsTest extends TestCase
{

    use RefreshDatabase,
        WithFaker;

    public function test_blog_subscriber_policies_endpoint()
    {

        $blogSubscriber = \Innoboxrr\LaravelBlog\Models\BlogSubscriber::factory()->create();
        
        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'id' => $blogSubscriber->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-subscriber/policies', $payload, $headers)
            ->assertStatus(200);

    }

    public function test_blog_subscriber_policy_endpoint()
    {
        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'policy' => 'index'
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-subscriber/policy', $payload, $headers)
            ->assertJsonStructure([
                'index'
            ])
            ->assertStatus(200);

    }

    public function test_blog_subscriber_index_auth_endpoint()
    {

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'managed' => true
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-subscriber/index', $payload, $headers)
            ->assertStatus(200);

    }

    public function test_blog_subscriber_index_guest_endpoint()
    {

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'managed' => true
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-subscriber/index', $payload, $headers)
            ->assertStatus(401);
            
    }
    
    public function test_blog_subscriber_show_auth_endpoint()
    {

        $blogSubscriber = \Innoboxrr\LaravelBlog\Models\BlogSubscriber::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_subscriber_id' => $blogSubscriber->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-subscriber/show', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_subscriber_show_guest_endpoint()
    {

        $blogSubscriber = \Innoboxrr\LaravelBlog\Models\BlogSubscriber::latest()->first();

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_subscriber_id' => $blogSubscriber->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-subscriber/show', $payload, $headers)
            ->assertStatus(401);
            
    }

    public function test_blog_subscriber_create_endpoint()
    {

        $user = \Innoboxrr\LaravelBlog\Models\User::first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = \Innoboxrr\LaravelBlog\Models\BlogSubscriber::factory()->make()->getAttributes();

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-subscriber/create', $payload, $headers)
            ->assertStatus(201);
            
    }

    public function test_blog_subscriber_update_endpoint()
    {

        $blogSubscriber = \Innoboxrr\LaravelBlog\Models\BlogSubscriber::factory()->create();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            ...\Innoboxrr\LaravelBlog\Models\BlogSubscriber::factory()->make()->getAttributes(),
            'blog_subscriber_id' => $blogSubscriber->id
        ];

        $this->json('PUT', '/api/innoboxrr/laravelblog/blog-subscriber/update', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_subscriber_delete_endpoint()
    {

        $blogSubscriber = \Innoboxrr\LaravelBlog\Models\BlogSubscriber::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_subscriber_id' => $blogSubscriber->id
        ];

        $this->json('DELETE', '/api/innoboxrr/laravelblog/blog-subscriber/delete', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_subscriber_restore_endpoint()
    {

        $blogSubscriber = \Innoboxrr\LaravelBlog\Models\BlogSubscriber::first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_subscriber_id' => $blogSubscriber->id
        ];

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-subscriber/restore', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_subscriber_force_delete_endpoint()
    {

        $blogSubscriber = \Innoboxrr\LaravelBlog\Models\BlogSubscriber::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_subscriber_id' => $blogSubscriber->id
        ];

        $this->json('DELETE', '/api/innoboxrr/laravelblog/blog-subscriber/force-delete', $payload, $headers)
            ->assertStatus(403);
            
    }

    public function test_blog_subscriber_export_endpoint()
    {   

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            //
        ];

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-subscriber/export', $payload, $headers)
            ->assertStatus(200);
            
    }

}
