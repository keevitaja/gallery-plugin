<?php 

namespace Keevitaja\GalleryPlugin\Commands;

use Anomaly\FilesModule\File\Command\GetFile;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Keevitaja\GalleryPlugin\AnchorBuilder;
use Keevitaja\GalleryPlugin\AnchorComponents;

class GetAnchor implements SelfHandling
{
    use DispatchesJobs;

    /**
     * Image identifier
     *
     * @var string
     */
    protected $identifier;

    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    public function handle()
    {
        $file = $this->dispatch(new GetFile($this->identifier));

        if ($file) return new AnchorBuilder(new AnchorComponents($file));
    }
}