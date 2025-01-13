<div>
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <small>Publicado en: {{ $post->created_at->format('d M Y') }}</small>
</div>
