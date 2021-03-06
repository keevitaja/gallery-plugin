<?php

namespace Keevitaja\GalleryPlugin\Commands;

use Illuminate\Contracts\Bus\SelfHandling;

class ParseAttributes implements SelfHandling
{
    /**
     * Raw attributes
     *
     * @var array
     */
    protected $attributes;

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Parse raw attributes array
     *
     * @return string
     */
    public function handle()
    {
        $items = [];

        foreach ($this->attributes as $key => $value) {
            $items[] = in_array(false, $value) ? $key : $key.'="'. implode(' ', $value).'"';
        }

        return implode(' ', $items);
    }
}