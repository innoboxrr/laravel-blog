<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Illuminate\Support\Facades\View;
use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class BaseLivewireComponent extends Component
{
    public $blog;
    protected $theme;
    protected $themeConfig = [];
    protected $disableCache = true;

    public function boot()
    {
        $this->initializeThemeData();
        $this->shareViewData();
    }

    protected function initializeThemeData()
    {
        $this->blog = view()->shared('currentBlog');
        $this->theme = view()->shared('theme');
        $this->themeConfig = $this->getThemeConfig();
    }

    protected function getThemeConfig()
    {
        return Cache::rememberForever($this->cacheKey("laravel-blog:theme-config:{$this->theme}"), function () {
            return [
                'theme' => $this->theme,
                'themeDir' => "laravel-blog::livewire.themes.{$this->theme}",
                'themeView' => "laravel-blog::livewire.themes.{$this->theme}.views",
                'themeLayout' => "laravel-blog::livewire.themes.{$this->theme}.layout.app",
            ];
        });
    }

    protected function shareViewData()
    {
        view()->share(array_merge([
            'blog' => $this->blog
        ], $this->themeConfig));
    }

    protected function getLayoutData(array $override = [])
    {
        $default = config('laravel-blog.layout_data');
        $customLayoutData = $this->loadThemeLayoutData();
        $data = array_merge($default, $override, $customLayoutData);
        return ['layoutData' => $data];
    }

    private function loadThemeLayoutData(): array
    {
        return Cache::rememberForever($this->cacheKey("laravel-blog:theme-layout-data:{$this->theme}"), function () {
            try {
                $template = "laravel-blog::livewire.themes.{$this->theme}.layout.app";

                $resolvedViewPath = View::getFinder()->find($template);
                $themePath = dirname(dirname($resolvedViewPath)); // sube 2 niveles
                $layoutFile = $themePath . '/config/LayoutData.php';

                if (file_exists($layoutFile)) {
                    require_once $layoutFile;

                    if (class_exists('LayoutData') && method_exists('LayoutData', 'toArray')) {
                        return \LayoutData::toArray($this);
                    }
                }
            } catch (\Exception $e) {
                report($e);
                // Log::warning("Error loading theme layout data for '{$this->theme}': " . $e->getMessage());
            }

            return [];
        });
    }

    private function cacheKey($key)
    {
        if(app()->environment('local') && $this->disableCache) {
            return $key . ':' . rand(1, 1000);
        } else {
            return $key;
        }
    }

    protected function renderView($view, $data = [], $layout = [], $section = 'content')
    {
        return view("{$this->themeConfig['themeView']}.blog-$view-view", $data)
            ->extends($this->themeConfig['themeLayout'], $this->getLayoutData($layout))
            ->section($section);
    }
}
