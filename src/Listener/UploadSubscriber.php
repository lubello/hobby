<?php


namespace App\Listener;


use App\Annotation\UploadableField;
use App\Annotation\UploadAnnotationReader;
use App\Handler\UploadHandler;
use Doctrine\Common\EventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class UploadSubscriber implements EventSubscriber
{

    /**
     * @var UploadAnnotationReader
     */
    private $uploadAnnotationReader;
    /**
     * @var UploadHandler
     */
    private $uploadHandler;

    public function __construct(UploadAnnotationReader $uploadAnnotationReader,
                                UploadHandler $uploadHandler)
    {
        $this->uploadAnnotationReader = $uploadAnnotationReader;
        $this->uploadHandler = $uploadHandler;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {   return [
            'prePersist',
            'postLoad',
            'preUpdate',
            'postRemove',
        ];
    }

    public function prePersist(LifecycleEventArgs $event) {
        $this->preEvent($event);
    }
    public function preUpdate(LifecycleEventArgs $event) {
        $this->preEvent($event);
    }

    private function preEvent(LifecycleEventArgs $event) {
        $entity = $event->getEntity();
        foreach ($this->uploadAnnotationReader->getUploadableFields($entity) as $property => $annotation) {
            $this->uploadHandler->uploadFile($entity, $property, $annotation);
            //var_dump($property, $annotation);
        }
    }


    public function postLoad(LifecycleEventArgs $event) {
        $entity = $event->getEntity();
        foreach ($this->uploadAnnotationReader->getUploadableFields($entity) as $property => $annotation) {
            $this->uploadHandler->setFileFromFilename($entity, $property, $annotation);
        }
    }

    public function postRemove(LifecycleEventArgs $event) {
        $entity = $event->getEntity();
        foreach ($this->uploadAnnotationReader->getUploadableFields($entity) as $property => $annotation) {
            // supprimer le fichier
            $this->uploadHandler->removeFile($entity, $property);
        }
    }



}

















