<?php namespace Keevitaja\GalleryPlugin;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Keevitaja\GalleryPlugin\Commands\GetAnchorTag;
use Keevitaja\GalleryPlugin\Commands\GetGalleryTag;
use Twig_SimpleFunction;

class GalleryPlugin extends Plugin
{
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                config('keevitaja.plugin.gallery::addon.plugin.anchor'),
                function($identifier) {
                    return $this->dispatch(new GetAnchorTag($identifier));
                }
            ),
            new Twig_SimpleFunction(
                config('keevitaja.plugin.gallery::addon.plugin.gallery'),
                function($identifier) {
                    return $this->dispatch(new GetGalleryTag($identifier));
                }
            )
        ];
    }
}
