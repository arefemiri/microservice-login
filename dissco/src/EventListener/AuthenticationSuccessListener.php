<?php

namespace App\EventListener;

use App\Controller\AbstractApiController;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class AuthenticationSuccessListener extends AbstractApiController
{

    /**
     * @param AuthenticationSuccessEvent $event
     * @throws ExceptionInterface
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {

        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        // set last login
        $user->setLastLogin(new \DateTime());
        $oManager = $this->getDoctrine()->getManager();
        $oManager->persist($user);
        $oManager->flush();

        // formatted data return
        $formattedData = array(
            'status'=>true,
            'userId' => $user->getId(),
            'token' => $data['token']
        );
        $event->setData($formattedData);
    }
}
