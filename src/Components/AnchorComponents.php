<?php 

namespace Keevitaja\GalleryPlugin\Components;

class AnchorComponents
{
    public $file;

    public $entry;

    public $original;

    public $image;

    public $attributes = '';

    public function __construct($file)
    {
        $this->file = $file;
        $this->entry = $this->file->entry;
        $this->original = $this->file->image();
        $this->image = clone($this->original);
    }
}