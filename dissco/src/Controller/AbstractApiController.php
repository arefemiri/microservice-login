<?php

declare(strict_types=1);

namespace App\Controller;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


abstract class AbstractApiController extends AbstractFOSRestController
{

    protected function buildForm(string $type, $data = null, array $options = []): FormInterface
    {
        $options = array_merge($options, [
            'csrf_protection' => false,
        ]);

        return $this->container->get('form.factory')->createNamed('', $type, $data, $options);
    }

    protected function respond($data, int $statusCode = Response::HTTP_OK): Response
    {
        return $this->handleView($this->view($data, $statusCode));
    }

    protected function jsonResponse($data, int $statusCode = Response::HTTP_OK): Response
    {
        return $this->json($data, $statusCode);
    }

    /**
     * @throws ExceptionInterface
     */
    protected function serializer($data, $attributes = null)
    {
        $dateCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof DateTime ? $innerObject->format(DateTimeInterface::ISO8601) : '';
        };

        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'createdAt' => $dateCallback,
                'updatedAt' => $dateCallback,
            ],
        ];

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new GetSetMethodNormalizer($classMetadataFactory, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer]);

        if ($attributes) {
            return $serializer->normalize($data, null, [AbstractNormalizer::ATTRIBUTES => $attributes]);
        }

        return $serializer->normalize($data, null, [ObjectNormalizer::ENABLE_MAX_DEPTH => true]);

    }
}
