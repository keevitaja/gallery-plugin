<?php 

namespace Keevitaja\GalleryPlugin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Keevitaja\GalleryPlugin\Commands\GetAnchor;

class GalleryBuilder extends Builder
{
    use DispatchesJobs;

    public $gallery;

    protected $passes = [];

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

    public function __call($method, $args)
    {
        $method = strtolower(str_replace('image', '', $method));

        $this->passes[$method] = $args;

        return $this;
    }

    public function get()
    {
        $anchors = [];

        foreach ($this->anchors as $anchor) {
            foreach ($this->passes as $method => $args) {
                $anchor = call_user_func_array([$anchor, $method], $args);
            }

            $anchors[] = $anchor->get();
        }
        
        $this->gallery->attributes = (new AttributesParser())->parse($this->attributes);
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