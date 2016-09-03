<?php 

namespace Keevitaja\GalleryPlugin\Components;

class AnchorComponents
{
    /**
     * FileModel
     *
     * @var Anomaly\FilesModule\File\FileModel
     */
    public $file;

    /**
     * FilesImagesEntryModel
     *
     * @var Anomaly\Streams\Platform\Model\Files\FilesImagesEntryModel
     */
    public $entry;

    /**
     * Image
     *
     * @var Anomaly\Streams\Platform\Image\Image
     */
    public $original;

    /**
     * Image
     *
     * @var Anomaly\Streams\Platform\Image\Image
     */
    public $image;

    /**
     * Parsed attributes
     *
     * @var string
     */
    public $attributes = '';

    public function __construct($file)
    {
        $this->file = $file;
        $this->entry = $this->file->entry;
        $this->original = $this->file->image();
        $this->image = clone($this->original);
    }
}