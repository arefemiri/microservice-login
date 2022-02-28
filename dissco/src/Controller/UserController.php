<?php

declare(strict_types=1);

namespace App\Controller;


use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("api/user")
 */

class UserController extends AbstractApiController
{
    /**
     * @Route("/data", name="user_show",methods={"GET"})
     */
    public function show(UserInterface $user): Response
    {

        $userData = $this->serializer($user,['name', 'family', 'username', 'email', 'countryCode', 'mobileNo', 'password', 'passportNumber']);
        $userData['passportImage']=utf8_encode(stream_get_contents($user->getPassportImage()));
//        $userData['passportImage']=$user->getPassportImage();
//        header("Content-type: image/jpeg");
//        echo $userData['passportImage'];die;
        return $this->jsonResponse( $userData,200);
    }
}
