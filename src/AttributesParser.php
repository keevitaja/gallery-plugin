<?php

namespace Keevitaja\GalleryPlugin;

class AttributesParser
{
    /**
     * Parses attributes array
     *
     * @param  array $attributes
     *
     * @return string
     */
    public function parse($attributes)
    {
        $items = [];

        foreach ($attributes as $key => $value) {
            $items[] = in_array(false, $value) ? $key : $key.'="'. implode(' ', $value).'"';
        }

        return implode(' ', $items);
    }
}