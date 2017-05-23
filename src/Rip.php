<?php
/**
 * Created by gerk on 19.09.16 06:09
 */

namespace PeekAndPoke\Component\Rip;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use PeekAndPoke\Component\MetaCore\Builder;
use PeekAndPoke\Component\MetaCore\DomainModel as MetaCore;
use PeekAndPoke\Component\MetaCore\DomainModel\Type;
use PeekAndPoke\Component\Psi\Functions\Unary\Matcher\IsInstanceOf;
use PeekAndPoke\Component\Psi\Psi;
use PeekAndPoke\Component\Rip\DomainModel\Endpoint;
use PeekAndPoke\Component\Rip\DomainModel\Swagger2;
use PeekAndPoke\Component\Slumber\Core\Codec\ArrayCodec;


/**
 * Rip
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class Rip
{
    /** @var ArrayCodec */
    private $codec;
    /** @var AnnotationReader */
    private $annotationReader;

    /** @var Builder */
    private $metaCoreBuilder;

    /**
     * Rip constructor.
     *
     * @param ArrayCodec $codec
     * @param Reader     $annotationReader
     */
    public function __construct(ArrayCodec $codec, Reader $annotationReader)
    {
        $this->codec            = $codec;
        $this->annotationReader = $annotationReader;

        // setup the meta core builder so that it care acquire additional information
        // from Slumber annotations, like the real type of an array (List vs Map)
        $this->metaCoreBuilder = new Builder(
            $annotationReader,
            new SlumberPropertyFilter($codec->getEntityConfigReader()),
            new SlumberPropertyMapper($codec->getEntityConfigReader())
        );
    }

    /**
     * @return ArrayCodec
     */
    public function getCodec()
    {
        return $this->codec;
    }

    /**
     * @return Builder
     */
    public function getMetaCoreBuilder()
    {
        return $this->metaCoreBuilder;
    }

    /**
     * @param Endpoint[] $endpoints
     *
     * @return Swagger2\Swagger2Config
     */
    public function buildSwaggerModel($endpoints)
    {
        /** @var Swagger2\ResourcePath[][] $resourcePaths */
        $resourcePaths = [];
        /** @var Swagger2\Tag[] $tags */
        $tags = [
            Swagger2\Tag::from('default', 'Default group'),
        ];

        foreach ($endpoints as $endpoint) {
            /** @var Rip\ApiOperation|null $apiOperation */
            $apiOperation = $this->annotationReader->getMethodAnnotation($endpoint->getHandlerMethod(), Rip\ApiOperation::class);

            $key        = $endpoint->getUriPattern();
            $httpMethod = strtolower($endpoint->getHttpMethod());

            if ($apiOperation !== null && ! isset($paths[$key][$httpMethod])) {

                $current = (new Swagger2\ResourcePath())
                    ->setOperationId($endpoint->getId())
                    ->setSummary($apiOperation->value);

                /** @var Rip\Api $apiAnnotation */
                $apiAnnotation = $this->annotationReader->getClassAnnotation($endpoint->getHandlerMethod()->getDeclaringClass(), Rip\Api::class);

                if ($apiAnnotation) {
                    $tags[$apiAnnotation->value] = Swagger2\Tag::from($apiAnnotation->value, $apiAnnotation->description);
                    $current->addTag($apiAnnotation->value);
                } else {
                    $current->addTag('default');
                }

                // request body param
                if ($apiOperation->request) {
                    $type = $this->metaCoreBuilder->buildForClass(new \ReflectionClass($apiOperation->request));

                    $current->addParameter(
                        (new Swagger2\ParamDefinition())
                            ->setIn('body')
                            ->setSchema(Swagger2\TypeReference::toDefinitions($this->convertTypeToString($type)))
                            ->setRequired(true)
                            ->setName('request')
                    );
                }

                // path param
                foreach ($apiOperation->params as $k => $v) {
                    $current->addParameter(
                        (new Swagger2\ParamDefinition())
                            ->setIn('path')
                            ->setName($k)
                            ->setDescription($v)
                            ->setType('string')
                    );
                }

                $current->setResponses(
                    Psi::it($this->annotationReader->getMethodAnnotations($endpoint->getHandlerMethod()))
                        ->filter(new IsInstanceOf(Rip\ApiResponse::class))
                        ->toMap(
                            function (Rip\ApiResponse $r) { return $r->code; },
                            function (Rip\ApiResponse $r) {

                                $def = (new Swagger2\ResponseDefinition())->setDescription($r->message);

                                if (class_exists($r->response)) {

                                    $type = $this->metaCoreBuilder->buildForClass(new \ReflectionClass($r->response));

                                    // TODO: handle container "map"

                                    if ($r->responseContainer === 'list') {
                                        $def->setSchema(
                                            (new Swagger2\TypeReference())
                                                ->setType('array')
                                                ->setItems(Swagger2\TypeReference::toDefinitions($this->convertTypeToString($type)))
                                        );
                                        $def->setDescription(
                                            $this->convertTypeToString(Type::list_($type->ref()))
                                        );
                                    } else {
                                        $def->setSchema(Swagger2\TypeReference::toDefinitions($this->convertTypeToString($type)));
                                    }
                                }

                                return $def;
                            }
                        )
                );

                $resourcePaths[$key][$httpMethod] = $current;

                // TODO: validate that all params are annotated
            }
        }

        $typesMapped = Psi::it($this->metaCoreBuilder->getTypeRegistry()->getTypes())
            ->filter(new IsInstanceOf(Type\ObjectType::class))
            ->toMap(
                function (Type\ObjectType $type) {
                    return $this->convertTypeToString($type);
                },
                function (Type\ObjectType $type) {
                    $def = new Swagger2\TypeDefinition();

                    // todo: the docs of the object

//                    if ($type->getDocBlock()) {
//                        $def->setDescription($spec->getDocBlock()->getSummary());
//                    } else {
//                        $def->setDescription($spec->getName());
//                    }

                    /** @var string[] $requiredProperties */
                    $requiredProperties = [];
                    /** @var Swagger2\Property[] $mappedProps */
                    $mappedProps = [];

                    // todo: all properties

                    foreach ($this->metaCoreBuilder->getAllProperties($type) as $property) {

                        if ($property->isNullable() === false) {
                            $requiredProperties[] = $property->getName();
                        }

                        $currentProp = new Swagger2\Property();
                        // setup the defaults
                        $currentProp->setType(strtolower($property->getName()));

                        if ($property->getDoc()) {
                            $currentProp->setDescription(
                                $property->getDoc()->getSummary()
                            );
                        }

                        $propertyType = $this->metaCoreBuilder->buildForRef($property->getTypeRef());

                        // give some special touch
                        if ($propertyType instanceof Type\EnumType) {

                            $currentProp->setType('string');
                            $currentProp->setEnum($propertyType->getValues());
                            $currentProp->setRef(
                                Swagger2\TypeReference::toDefinitions(
                                    $this->convertTypeToString($propertyType)
                                )->getRef()
                            );

                        } elseif ($propertyType instanceof MetaCore\Type\ListType) {

                            $valueType     = $this->metaCoreBuilder->buildForRef($propertyType->getValueTypeRef());
                            $valueTypeName = $this->convertTypeToString($valueType);

                            $currentProp->setType('array');
                            $currentProp->setItems(
                                Swagger2\TypeReference::toDefinitions($valueTypeName)
                            );
                            $currentProp->setDescription($this->convertTypeToString($propertyType));

                        } elseif ($propertyType instanceof MetaCore\Type\MapType) {

                            $valueType     = $this->metaCoreBuilder->buildForRef($propertyType->getValueTypeRef());
                            $valueTypeName = $this->convertTypeToString($valueType);

                            $currentProp->setType('object');
                            $currentProp->setAdditionalProperties(
                                (new Swagger2\TypeReference())->setType('string')
                            );
                            $currentProp->setItems(
                                Swagger2\TypeReference::toDefinitions($valueTypeName)
                            );
                            $currentProp->setDescription($this->convertTypeToString($propertyType));

                        } else if ($propertyType instanceof Type\ObjectType) {

                            $currentProp->setType('object');
                            $currentProp->setRef(
                                Swagger2\TypeReference::toDefinitions($this->convertTypeToString($propertyType))->getRef()
                            );

                        } else {

                            // TODO: map to scalar types that Swagger understands
                            // see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#data-types

                            $currentProp->setType(strtolower($propertyType->getId()));
                        }

                        $mappedProps[$property->getName()] = $currentProp;
                    }

                    $def->setRequired($requiredProperties);
                    $def->setProperties($mappedProps);

                    return $def;
                }
            );

        return (new Swagger2\Swagger2Config())
            ->setBasePath('/')
            ->setTags($tags)
            ->setPaths($resourcePaths)
            ->setDefinitions($typesMapped);
    }

    /**
     * @param Type $type
     *
     * @return mixed
     */
    private function convertTypeToString(Type $type)
    {
        return str_replace(
            ['<', '>'],
            ['«', '»'],
            $this->metaCoreBuilder->buildFullName($type->ref())
        );
    }
}
