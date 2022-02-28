<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AuthController extends AbstractApiController
{
    /**
     * @Route("/a", name="user_registder")
     */
    public function regdister(UserRepository $repository)
    {
        $user = $repository->find(1);
        var_dump($user->getId());
        die;
    }

    /**
     * @Route("api/register", name="user_register",methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $form = $this->buildForm(RegisterType::class);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->jsonResponse($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var User $user */
        $user = $form->getData();

        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $form->get('password')->getData()
            )
        );

        $image = $form['passportImage']->getData();
        if (is_uploaded_file($image)) {
            $imgData = file_get_contents($image);
            $user->setPassportImage($imgData);
        } else {
            var_dump('dd');
            die;
        }

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->json(['status' => true, 'userId' => $user->getId()]);
    }

}
