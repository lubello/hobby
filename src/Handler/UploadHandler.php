<?php

namespace App\Handler;

use App\Annotation\UploadableField;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class UploadHandler
{
    /**
     * @var PropertyAccessor
     */
    private $accessor;

    public function __construct()
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param $entity
     * @param $property
     * @param UploadableField $annotation
     */
    public function uploadFile($entity, $property, $annotation) {
        $file = $this->accessor->getValue($entity, $property);
        if ($file instanceof UploadedFile) {
            // supprimer l'ancien fichier
            $this->removeOldFile($entity, $property, $annotation);

            $filename = $file->getClientOriginalName();

            //$id = $this->accessor->getValue($entity, "id");
            //$filename = "id". "-". $filename;

            // TODO donner un nom unique du style guid
            $file->move($annotation->getPath(), $filename);
            $this->accessor->setValue($entity, $annotation->getFilename(), $filename);
        }
    }

    /**
     * @param $entity
     * @param $property
     * @param UploadableField $annotation
     */
    public function setFileFromFilename($entity, $property, $annotation) {
        /** @var ?File $file */
        $file = $this->getFileFromFilename($entity, $annotation);
        $this->accessor->setValue($entity, $property, $file);
    }

    public function removeOldFile($entity, $property, $annotation) {
        /** @var ?File $file */
        $file = $this->getFileFromFilename($entity, $annotation);
        if (isset($file)) {
            @unlink($file->getRealPath());
        }
    }

    /**
     * @param $entity
     * @param UploadableField $annotation
     * @return File|null
     */
    private function getFileFromFilename($entity, $annotation): ?File {
        $filename = $this->accessor->getValue($entity, $annotation->getFilename());
        if (isset($filename)) {
            // TODO tester si il existe
            $fullFilename = $annotation->getPath() . DIRECTORY_SEPARATOR . $filename;
            if (file_exists($fullFilename)) {
                return new file($fullFilename);
            }
        }

        return null;
    }

    public function removeFile($entity, $property)
    {
        $file = $this->accessor->getValue($entity, $property);
        if ($file instanceof File) {
            @unlink($file->getRealPath());
        }
    }

}