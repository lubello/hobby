<?php


namespace App\Annotation;

use http\Exception\InvalidArgumentException;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class UploadableField
{
    private $filename;
    private $path;

    public function __construct(array $options)
    {
        if (empty($options['name'])) {
            throw new InvalidArgumentException('UploadableField, annotation absante: name');
        }
        if (empty($options['path'])) {
            throw new InvalidArgumentException('UploadableField, annotation absante: path');
        }

        //dump($options);
        $this->filename = $options['name'];
        $this->path     = $options['path'];


    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

}