<?php
/**
 * Created by gerk on 20.09.16 16:34
 */

namespace PeekAndPoke\Component\Rip\DomainModel;


/**
 * Endpoint
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class Endpoint
{
    /** @var string */
    private $id;
    /** @var string */
    private $uriPattern;
    /** @var string GET, POST, ... */
    private $httpMethod;
    /** @var \ReflectionMethod */
    private $handlerMethod;

    /**
     * Endpoint constructor.
     *
     * @param                   $id
     * @param                   $uriPattern
     * @param                   $httpMethod
     * @param \ReflectionMethod $handlerMethod
     */
    public function __construct($id, $uriPattern, $httpMethod, \ReflectionMethod $handlerMethod)
    {
        $this->id            = $id;
        $this->uriPattern    = $uriPattern;
        $this->httpMethod    = $httpMethod;
        $this->handlerMethod = $handlerMethod;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUriPattern()
    {
        return $this->uriPattern;
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @return \ReflectionMethod
     */
    public function getHandlerMethod()
    {
        return $this->handlerMethod;
    }
}
