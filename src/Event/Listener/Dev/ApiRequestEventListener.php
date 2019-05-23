<?php

namespace App\Event\Listener\Dev;

use App\Domain\DataInteractor\DataProvider\User\UserDataProvider;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ApiRequestEventListener
{
    /** @var UserDataProvider */
    private $userDataProvider;

    /** @var JWTTokenManagerInterface */
    private $tokenManager;

    /** @var int */
    private $defaultUserId;

    /** @var bool */
    private $wrapApiResponse;

    public function __construct(UserDataProvider $userDataProvider, JWTTokenManagerInterface $tokenManager, ?int $defaultUserId, bool $wrapApiResponse)
    {
        $this->userDataProvider = $userDataProvider;
        $this->tokenManager = $tokenManager;
        $this->defaultUserId = $defaultUserId;
        $this->wrapApiResponse = $wrapApiResponse;
    }

    public function addTokenToRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        $path = $request->getPathInfo();
        if (null === $this->defaultUserId || $request->headers->has('Authorization') || 0 !== strpos($path, '/api')) {
            return;
        }

        $user = $this->userDataProvider->getOneById($this->defaultUserId);
        if (null === $user) {
            return;
        }

        $token = $this->tokenManager->create($user);
        $request->headers->add(['Authorization' => "Bearer $token"]);
    }

    public function convertResponseToHtml(FilterResponseEvent $event): void
    {
        $request = $event->getRequest();
        $path = $request->getPathInfo();
        if (false === $this->wrapApiResponse
            || 0 !== strpos($path, '/api')
            || Response::HTTP_OK !== $event->getResponse()->getStatusCode()) {
            return;
        }

        if (false === $event->isMasterRequest()) {
            return;
        }

        if (false === $request->headers->has('Accept') || false === strpos($request->headers->get('Accept'), 'text/html')) {
            return;
        }

        $response = $event->getResponse();
        $content = json_encode(json_decode($response->getContent()), JSON_PRETTY_PRINT);
        $response->setContent('<html><body><pre><code>'.htmlspecialchars($content).'</code></pre></body></html>');

        $response->headers->set('Content-Type', 'text/html; charset=UTF-8');
        $request->setRequestFormat('html');
        $event->setResponse($response);
    }
}
