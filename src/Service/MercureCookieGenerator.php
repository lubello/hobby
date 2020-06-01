<?php

namespace App\Service;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Symfony\Component\Security\Core\User\User;


class MercureCookieGenerator
{
    /**
     * @var string
     */
    private $secret;

    /**
     * MercureCookieGenerator constructor.
     * @param string $secret
     */
    public function __construct(string $secret)
    {

        $this->secret = $secret;
    }


    public function generate(int $userId) {

        // "http://monsite/user/44"

        // Définir les cibles sur lequelles on écoute.
        $token = (new Builder())
            ->set('mercure', [ 'subscribe' => ["http://monsite/user/44"]])
            ->sign(new Sha256(), $this->secret)
            ->getToken();

        return "mercureAuthorization={$token}; path=/.well-known/mercure; ";
    }

}