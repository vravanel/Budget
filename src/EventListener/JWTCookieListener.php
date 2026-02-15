<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

class JWTCookieListener
{
    public function __construct(
        private string $appEnv,
        private int $tokenTtl,
    ) {
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $response = $event->getResponse();
        $data = $event->getData();

        if (!isset($data['token'])) {
            return;
        }

        $secure = $this->appEnv !== 'dev';

        $response->headers->setCookie(
            Cookie::create('BEARER')
                ->withValue($data['token'])
                ->withExpires(new \DateTimeImmutable('+' . $this->tokenTtl . ' seconds'))
                ->withPath('/')
                ->withSecure($secure)
                ->withHttpOnly(true)
                ->withSameSite('lax')
        );

        // Retirer le token du body JSON pour ne pas l'exposer au JS
        unset($data['token']);
        $event->setData($data);
    }
}
