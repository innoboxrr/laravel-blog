<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire\Components;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;

class YoutubePlaylist extends Component
{
    public array $playlist = [];
    public string $currentVideoId = '';

    public function mount(array $playlist = [])
    {
        $this->playlist = is_array($playlist) ? $playlist : json_decode($playlist, true) ?? [];
        $this->currentVideoId = $this->playlist[0]['id'] ?? '';
    }

    public function selectVideo(string $id)
    {
        $this->currentVideoId = $id;
    }

    public function render()
    {
        return $this->renderComponent('youtube-playlist');
    }
}
