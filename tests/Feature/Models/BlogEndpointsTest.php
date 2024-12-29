<?php

namespace Innoboxrr\LaravelBlog\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Innoboxrr\LaravelBlog\Tests\TestCase;

class BlogEndpointsTest extends TestCase
{

    use RefreshDatabase,
        WithFaker;

    public function test_blog_policies_endpoint()
    {

        $blog = \Innoboxrr\LaravelBlog\Models\Blog::factory()->create();
        
        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'id' => $blog->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog/policies', $payload, $headers)
            ->assertStatus(200);

    }

    public function test_blog_policy_endpoint()
    {
        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'policy' => 'index'
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog/policy', $payload, $headers)
            ->assertJsonStructure([
                'index'
            ])
            ->assertStatus(200);

    }

    public function test_blog_index_auth_endpoint()
    {

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'managed' => true
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog/index', $payload, $headers)
            ->assertStatus(200);

    }

    public function test_blog_index_guest_endpoint()
    {

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'managed' => true
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog/index', $payload, $headers)
            ->assertStatus(401);
            
    }
    
    public function test_blog_show_auth_endpoint()
    {

        $blog = \Innoboxrr\LaravelBlog\Models\Blog::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_id' => $blog->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog/show', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_show_guest_endpoint()
    {

        $blog = \Innoboxrr\LaravelBlog\Models\Blog::latest()->first();

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_id' => $blog->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog/show', $payload, $headers)
            ->assertStatus(401);
            
    }

    public function test_blog_create_endpoint()
    {

        $user = \Innoboxrr\LaravelBlog\Models\User::first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = \Innoboxrr\LaravelBlog\Models\Blog::factory()->make()->getAttributes();

        $this->json('POST', '/api/innoboxrr/laravelblog/blog/create', $payload, $headers)
            ->assertStatus(201);
            
    }

    public function test_blog_update_endpoint()
    {

        $blog = \Innoboxrr\LaravelBlog\Models\Blog::factory()->create();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            ...\Innoboxrr\LaravelBlog\Models\Blog::factory()->make()->getAttributes(),
            'blog_id' => $blog->id
        ];

        $this->json('PUT', '/api/innoboxrr/laravelblog/blog/update', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_delete_endpoint()
    {

        $blog = \Innoboxrr\LaravelBlog\Models\Blog::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_id' => $blog->id
        ];

        $this->json('DELETE', '/api/innoboxrr/laravelblog/blog/delete', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_restore_endpoint()
    {

        $blog = \Innoboxrr\LaravelBlog\Models\Blog::first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_id' => $blog->id
        ];

        $this->json('POST', '/api/innoboxrr/laravelblog/blog/restore', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_force_delete_endpoint()
    {

        $blog = \Innoboxrr\LaravelBlog\Models\Blog::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_id' => $blog->id
        ];

        $this->json('DELETE', '/api/innoboxrr/laravelblog/blog/force-delete', $payload, $headers)
            ->assertStatus(403);
            
    }

    public function test_blog_export_endpoint()
    {   

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            //
        ];

        $this->json('POST', '/api/innoboxrr/laravelblog/blog/export', $payload, $headers)
            ->assertStatus(200);
            
    }

}
