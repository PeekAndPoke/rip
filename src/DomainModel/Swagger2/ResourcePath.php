<?php
/**
 * File was created 15.10.2015 17:24
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
namespace PeekAndPoke\Component\Rip\DomainModel\Swagger2;

use PeekAndPoke\Component\Slumber\Annotation\Slumber;

/**
 * Path
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class ResourcePath
{
    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $operationId;

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $summary;

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $description;

    /**
     * @var string[]
     *
     * @Slumber\AsList(
     *     @Slumber\AsString()
     * )
     */
    private $tags = [];

    /**
     * List of mime-types
     *
     * @var string[]
     *
     * @Slumber\AsList(
     *     @Slumber\AsString()
     * )
     */
    private $consumes = ['application/json'];

    /**
     * List of mime-types
     *
     * @var string[]
     *
     * @Slumber\AsList(
     *     @Slumber\AsString()
     * )
     */
    private $produces = ['application/json'];

    /**
     * @var ResponseDefinition[]
     *
     * @Slumber\AsMap(
     *     @Slumber\AsObject(ResponseDefinition::class)
     * )
     */
    private $responses = [];

    /**
     * @var ParamDefinition[]
     *
     * // TODO: have a type for the parameters
     *
     * @Slumber\AsList(
     *     @Slumber\AsObject(ParamDefinition::class)
     * )
     */
    private $parameters = [];

    /**
     * @return string
     */
    public function getOperationId()
    {
        return $this->operationId;
    }

    /**
     * @param string $operationId
     *
     * @return $this
     */
    public function setOperationId($operationId)
    {
        $this->operationId = $operationId;

        return $this;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     *
     * @return $this
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param string $tags
     *
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param string $tag
     *
     * @return $this
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getConsumes()
    {
        return $this->consumes;
    }

    /**
     * @param \string[] $consumes
     *
     * @return $this
     */
    public function setConsumes($consumes)
    {
        $this->consumes = $consumes;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getProduces()
    {
        return $this->produces;
    }

    /**
     * @param \string[] $produces
     *
     * @return $this
     */
    public function setProduces($produces)
    {
        $this->produces = $produces;

        return $this;
    }

    /**
     * @return ResponseDefinition[]
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @param ResponseDefinition[] $responses
     *
     * @return $this
     */
    public function setResponses($responses)
    {
        $this->responses = $responses;

        return $this;
    }

    /**
     * @return ParamDefinition[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param \mixed[] $parameters
     *
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @param ParamDefinition $parameter
     *
     * @return $this
     */
    public function addParameter(ParamDefinition $parameter)
    {
        $this->parameters[] = $parameter;

        return $this;
    }
}
