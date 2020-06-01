<?php


namespace App\Controller;

use App\Service\MercureCookieGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\Jwt\StaticJwtProvider;
use Symfony\Component\Security\Core\User\User;


class LuckyController extends AbstractController
{


    /**
     * @param int $userId
     * @param MercureCookieGenerator $cookieGenerator
     * @return string
     * @route("lucky/index/{userId}", name="lucky")
     */
    public function index(int $userId, MercureCookieGenerator $cookieGenerator) {

        $response = $this->render('lucky/index.html.twig', [
            'userId' => 44,
            'cookie' => $cookieGenerator->generate(44)
        ]);
        $response->headers->set('set-cookie', $cookieGenerator->generate(44));

        return $response;
    }

    /**
     * @param MessageBusInterface $bus
     * @param int|null $user
     * @return string
     * @route("lucky/ping/{user}", name="ping", methods={"POST"})
     */
    //public function ping(PublisherInterface $publisher) {
    public function ping(MessageBusInterface $bus, ?int $user = null) {
        $target = ["http://monsite/user/44" ]; // cibles (user)
        $target = [];
        $update = new update("http://monsite/ping/","giancarlo", $target);
        $bus->dispatch($update);

        return new Response('success');
    }

}
