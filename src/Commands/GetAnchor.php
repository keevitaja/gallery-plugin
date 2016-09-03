<?php 

namespace Keevitaja\GalleryPlugin\Commands;

use Anomaly\FilesModule\File\Command\GetFile;
use Anomaly\FilesModule\File\FileModel;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Keevitaja\GalleryPlugin\Builders\AnchorBuilder;
use Keevitaja\GalleryPlugin\Components\AnchorComponents;

class GetAnchor implements SelfHandling
{
    use DispatchesJobs;

    /**
     * Image identifier
     *
     * @var string|Anomaly\FilesModule\File\FileModel
     */
    protected $identifier;

    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Create anchor
     *
     * @return use Keevitaja\GalleryPlugin\AnchorBuilder
     */
    public function handle()
    {
        if ($this->identifier instanceof FileModel) {
            $file = $this->identifier;
        } else {
            $file = $this->dispatch(new GetFile($this->identifier));
        }

        if ($file) return new AnchorBuilder(new AnchorComponents($file));
    }
}