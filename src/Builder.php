<?php 

namespace Keevitaja\GalleryPlugin;

abstract class Builder
{
    /**
     * Anchor tag attributes
     *
     * @var array
     */
    protected $attributes;

    /**
     * Image view twig file
     *
     * @var string
     */
    protected $view;

    /**
     * Add anchor tag attribute. Chainable
     *
     * @param  string  $key
     * @param  mixed $value
     *
     * @return self
     */
    public function attr($key, $value = false)
    {
        $this->attributes[$key][] = $value;

        return $this;
    }

    /**
     * Clear all attributes. Chainable
     *
     * @return self
     */
    public function clear()
    {
        $this->attributes = [];

        return $this;
    }

    /**
     * Swap view file. Chainable
     *
     * @param  string $view
     *
     * @return self
     */
    public function view($view)
    {
        $this->view = $view;

        return $this;
    }
}

