<?php 

namespace Keevitaja\GalleryPlugin\Commands;

use Anomaly\FilesModule\Folder\Command\GetFolder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Keevitaja\GalleryPlugin\Builders\GalleryBuilder;

class GetGallery implements SelfHandling
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

    /**
     * Create gallery
     *
     * @return Keevitaja\GalleryPlugin\GalleryBuilder
     */
    public function handle()
    {
        $folder = $this->dispatch(new GetFolder($this->identifier));

        if ( ! $folder) return;

        $files = $folder->getFiles();

        if (count($files) > 0) return new GalleryBuilder($files);
    }
}