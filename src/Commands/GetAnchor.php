<?php 

namespace Keevitaja\GalleryPlugin\Commands;

use Anomaly\FilesModule\File\Command\GetFile;
use Illuminate\Contracts\Bus\SelfHandling;
use Keevitaja\GalleryPlugin\AnchorBuilder;

class GetAnchor implements SelfHandling
{
    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function handle()
    {
        return new class($this->file) {
            public $file;

            public $entry;

            public $original;

            public $image;

            public function __construct($file)
            {
                $this->file = $file;
                $this->entry = $this->file->entry;
                $this->original = $this->file->image();
                $this->image = clone($this->original);
            }
        };
    }
}