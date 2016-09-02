<?php 

namespace Keevitaja\GalleryPlugin\Commands;

use Anomaly\FilesModule\Folder\Command\GetFolder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Keevitaja\GalleryPlugin\GalleryBuilder;

class GetGalleryTag implements SelfHandling
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
        $folder = $this->dispatch(new GetFolder($this->identifier));

        if ( ! $folder) return;

        $files = $folder->getFiles();

        if (count($files) > 0) return new GalleryBuilder($files);
    }
}