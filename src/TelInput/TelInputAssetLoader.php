<?php

namespace Innoboxrr\LaravelBlog\TelInput;

/**
 * Lo que imprimen @laravelTelInputStyles y @laravelTelInputScripts. Ver TelInput.
 */
final class TelInputAssetLoader
{
    public static function outputStyles()
    {
        return view('laravel-tel-input::assets')->withType('styles');
    }

    public static function outputScripts()
    {
        return view('laravel-tel-input::assets')->withType('scripts');
    }
}
