<?php 

namespace Keevitaja\GalleryPlugin;

class AnchorBuilder extends Builder
{
    public $anchor;

    public function __construct($anchor)
    {
        $this->anchor = $anchor;
        $this->view = config('keevitaja.plugin.gallery::addon.view.anchor');
        $this->attributes['class'][] = config('keevitaja.plugin.gallery::addon.class.anchor');
    }

    /**
     * Call Anomaly\Streams\Platform\Image\Image method. Chainable
     *
     * @param  string $method
     * @param  array $args
     *
     * @return self
     */
    public function __call($method, $args)
    {
        $this->anchor->image = call_user_func_array([$this->anchor->image, $method], $args);

        return $this;
    }

    /**
     * Get anchor components
     *
     * @return Anonymous class
     */
    public function get()
    {
        $this->anchor->attributes = (new AttributesParser())->parse($this->attributes);

        return $this->anchor;
    }

    /**
     * Return anchor tag
     *
     * @return string
     */
    public function __toString()
    {
        return (string) view($this->view, ['anchor' => $this->get()]);
    }
}

