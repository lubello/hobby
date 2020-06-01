<?php


namespace App\Event;



use App\Entity\Marque;
use Symfony\Component\EventDispatcher\Event;

class TestEvent extends Event
{
    const name = 'badge.unlock';
    /**
     * @var Marque
     */
    private $marque;

    /**
     * TestEvent constructor.
     * @param Marque $marque
     */
    public function __construct(Marque $marque)
    {
        $this->marque = $marque;
    }

    /**
     * @return Marque
     */
    public function getMarque(): Marque
    {
        return $this->marque;
    }
}