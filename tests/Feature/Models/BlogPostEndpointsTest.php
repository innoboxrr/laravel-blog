<?php

namespace Innoboxrr\LaravelBlog\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Innoboxrr\LaravelBlog\Tests\TestCase;

class BlogPostEndpointsTest extends TestCase
{

    use RefreshDatabase,
        WithFaker;

    public function test_blog_post_policies_endpoint()
    {

        $blogPost = \Innoboxrr\LaravelBlog\Models\BlogPost::factory()->create();
        
        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'id' => $blogPost->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-post/policies', $payload, $headers)
            ->assertStatus(200);

    }

    public function test_blog_post_policy_endpoint()
    {
        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'policy' => 'index'
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-post/policy', $payload, $headers)
            ->assertJsonStructure([
                'index'
            ])
            ->assertStatus(200);

    }

    public function test_blog_post_index_auth_endpoint()
    {

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'managed' => true
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-post/index', $payload, $headers)
            ->assertStatus(200);

    }

    public function test_blog_post_index_guest_endpoint()
    {

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'managed' => true
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-post/index', $payload, $headers)
            ->assertStatus(401);
            
    }
    
    public function test_blog_post_show_auth_endpoint()
    {

        $blogPost = \Innoboxrr\LaravelBlog\Models\BlogPost::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_post_id' => $blogPost->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-post/show', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_post_show_guest_endpoint()
    {

        $blogPost = \Innoboxrr\LaravelBlog\Models\BlogPost::latest()->first();

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_post_id' => $blogPost->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-post/show', $payload, $headers)
            ->assertStatus(401);
            
    }

    public function test_blog_post_create_endpoint()
    {

        $user = \Innoboxrr\LaravelBlog\Models\User::first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = \Innoboxrr\LaravelBlog\Models\BlogPost::factory()->make()->getAttributes();

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-post/create', $payload, $headers)
            ->assertStatus(201);
            
    }

    public function test_blog_post_update_endpoint()
    {

        $blogPost = \Innoboxrr\LaravelBlog\Models\BlogPost::factory()->create();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            ...\Innoboxrr\LaravelBlog\Models\BlogPost::factory()->make()->getAttributes(),
            'blog_post_id' => $blogPost->id
        ];

        $this->json('PUT', '/api/innoboxrr/laravelblog/blog-post/update', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_post_delete_endpoint()
    {

        $blogPost = \Innoboxrr\LaravelBlog\Models\BlogPost::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_post_id' => $blogPost->id
        ];

        $this->json('DELETE', '/api/innoboxrr/laravelblog/blog-post/delete', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_post_restore_endpoint()
    {

        $blogPost = \Innoboxrr\LaravelBlog\Models\BlogPost::first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_post_id' => $blogPost->id
        ];

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-post/restore', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_post_force_delete_endpoint()
    {

        $blogPost = \Innoboxrr\LaravelBlog\Models\BlogPost::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_post_id' => $blogPost->id
        ];

        $this->json('DELETE', '/api/innoboxrr/laravelblog/blog-post/force-delete', $payload, $headers)
            ->assertStatus(403);
            
    }

    public function test_blog_post_export_endpoint()
    {   

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            //
        ];

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-post/export', $payload, $headers)
            ->assertStatus(200);
            
    }

}
