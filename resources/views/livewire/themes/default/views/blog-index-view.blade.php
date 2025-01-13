<div>
    <h2>Blog: {{ $blog->name }}</h2>
    <ul>
        @foreach ($posts as $post)
            <li>
                <a href="{{ route('blog.post', [$blog->slug, $post->slug]) }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>
    {{ $posts->links() }}
</div>
