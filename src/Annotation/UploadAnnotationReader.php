<?php

namespace App\Annotation;

use Doctrine\Common\Annotations\AnnotationReader;

class UploadAnnotationReader
{
    /**
     * @var AnnotationReader
     */
    private $reader;

    public function __construct(AnnotationReader $reader)
    {
        $this->reader = $reader;
    }

    public function isUploadable($entity) : bool {
        try {
            $reflexion = new \ReflectionClass(get_class($entity));
            return ($this->reader->getClassAnnotation($reflexion, Uploadable::class) !== null);

        } catch (\ReflectionException $e) {
            //var_dump($e);
        }
    }
    public function getUploadableFields($entity) : array {
        try {
            $reflexion = new \ReflectionClass(get_class($entity));
            if (!$this->isUploadable($entity)) {
                return [];
            }
            $properties = [];
            foreach ($reflexion->getProperties() as $property) {
                $annotation = $this->reader->getPropertyAnnotation($property,UploadableField::class);
                if($annotation !== null) {
                    $properties[$property->getName()] = $annotation;
                }
            }
            return $properties;

        } catch (\ReflectionException $e) {
            //var_dump($e);
        }
    }
}