<?php namespace Keevitaja\GalleryPlugin;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Keevitaja\GalleryPlugin\Commands\GetAnchor;
use Keevitaja\GalleryPlugin\Commands\GetGallery;
use Twig_SimpleFunction;

class GalleryPlugin extends Plugin
{
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                config('keevitaja.plugin.gallery::addon.plugin.anchor'),
                function($identifier) {
                    return $this->dispatch(new GetAnchor($identifier));
                }
            ),
            new Twig_SimpleFunction(
                config('keevitaja.plugin.gallery::addon.plugin.gallery'),
                function($identifier) {
                    return $this->dispatch(new GetGallery($identifier));
                }
            )
        ];
    }
}
