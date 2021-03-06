<?php 

namespace Keevitaja\GalleryPlugin\Builders;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Keevitaja\GalleryPlugin\Commands\GetAnchor;
use Keevitaja\GalleryPlugin\Commands\ParseAttributes;
use Keevitaja\GalleryPlugin\Components\GalleryComponents;

class GalleryBuilder extends Builder
{
    use DispatchesJobs;

    /**
     * Gallery components
     *
     * @var Keevitaja\GalleryPlugin\Components\GalleryComponents
     */
    protected $gallery;

    /**
     * Functions to apply to images
     *
     * @var array
     */
    protected $passes = [];

    /**
     * Anchor objects
     *
     * @var array
     */
    protected $anchors = [];

    public function __construct($files)
    {
        foreach ($files as $file) {
            $this->anchors[] = $this->dispatch(new GetAnchor($file))->clear();
        }

        $this->gallery = new GalleryComponents();
        $this->view = config('keevitaja.plugin.gallery::addon.view.gallery');
        $this->attributes['class'][] = config('keevitaja.plugin.gallery::addon.class.gallery');
    }

    /**
     * Filter anchors array by filters. Chainable
     *
     * @return self
     */
    public function keywords()
    {
        $keywords = func_get_args();
        $anchors = [];

        foreach ($this->anchors as $anchor) {
            $matches = array_intersect($keywords, $anchor->anchor->file->keywords);

            if (count($matches) == count($keywords)) {
                $anchors[] = $anchor;
            }
        }

        $this->anchors = $anchors;

        return $this;
    }

    /**
     * Applay to Keevitaja\GalleryPlugin\Builders\AnchorBuilder. Chainable
     *
     * @param  string $method
     * @param  array $args
     *
     * @return self
     */
    public function __call($method, $args)
    {
        $method = strtolower(str_replace('image', '', $method));

        $this->passes[] = [$method, $args];

        return $this;
    }

    /**
     * Get gallery components
     *
     * @return Keevitaja\GalleryPlugin\Components\GalleryComponents
     */
    public function get()
    {
        $anchors = [];

        foreach ($this->anchors as $anchor) {
            foreach ($this->passes as $pass) {
                $anchor = call_user_func_array([$anchor, $pass[0]], $pass[1]);
            }

            $anchors[] = $anchor->get();
        }
        
        $this->gallery->attributes = $this->dispatch(new ParseAttributes($this->attributes));
        $this->gallery->anchors = $anchors;

        return $this->gallery;
    }

    /**
     * Return gallery tag
     *
     * @return string
     */
    public function __toString()
    {
        return (string) view($this->view, ['gallery' => $this->get()]);
    }
}