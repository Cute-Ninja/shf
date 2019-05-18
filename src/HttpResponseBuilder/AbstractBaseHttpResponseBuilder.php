<?php

namespace App\HttpResponseBuilder;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Templating\EngineInterface;

abstract class AbstractBaseHttpResponseBuilder
{
    public const DEFAULT_SERIALIZATION_GROUP = 'default';

    /** @var EngineInterface */
    private $twig;

    /** @var Serializer */
    protected $serializer;

    public function __construct(EngineInterface $twig)
    {
        $this->twig = $twig;

        if (null === $this->serializer) {
            $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
            $objectNormalizer = new ObjectNormalizer($classMetadataFactory);
            $dateTimeNormalizer = new DateTimeNormalizer();
            $this->serializer = new Serializer(
                [$dateTimeNormalizer, $objectNormalizer],
                [new JsonEncoder()]
            );
        }
    }

    protected function buildResponse($data, int $statusCode, ?array $serializationGroups = []): Response
    {
        $serializationGroups = $this->buildSerializationGroups($serializationGroups);
        if (false === empty($serializationGroups) && true === $this->shouldSerializeData($data, $statusCode)) {
            $data = $this->serializer->normalize($data, null, ['groups' => $serializationGroups]);
        }

        return new JsonResponse($data, $statusCode);
    }

    private function shouldSerializeData($data, int $statusCode): bool
    {
        if (null === $data || true === empty($data)) {
            return false;
        }

        if (false === in_array($statusCode, [Response::HTTP_OK, Response::HTTP_CREATED], true)) {
            return false;
        }

        return true;
    }

    private function buildSerializationGroups($serializationGroups): array
    {
        if (true === empty($serializationGroups)) {
            return [self::DEFAULT_SERIALIZATION_GROUP];
        }

        if (in_array(self::DEFAULT_SERIALIZATION_GROUP, $serializationGroups)) {
            return $serializationGroups;
        }

        $serializationGroups[] = self::DEFAULT_SERIALIZATION_GROUP;

        return $serializationGroups;
    }
}
