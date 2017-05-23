<?php
/**
 * File was created 15.10.2015 17:16
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
namespace PeekAndPoke\Component\Rip\DomainModel\Swagger2;

use PeekAndPoke\Component\Slumber\Annotation\Slumber;


/**
 * Swagger2Config
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class Swagger2Config
{
    /**
     * @var string The swagger version used
     *
     * @Slumber\AsString()
     */
    private $swagger = '2.0';

    /**
     * @var Info
     *
     * @Slumber\AsObject(Info::class)
     */
    private $info;

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $host;

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $basePath;

    /**
     * @var Tag[]
     *
     * @Slumber\AsList(
     *  @Slumber\AsObject(Tag::class)
     * )
     */
    private $tags = [];

    /**
     * @var ResourcePath[][]  The first dimension is the uri, the second the http method.
     *
     * @Slumber\AsMap(
     *     @Slumber\AsMap(
     *          @Slumber\AsObject(ResourcePath::class)
     *     )
     * )
     */
    private $paths = [];

    /**
     * @var TypeDefinition[]    The key is the types name, the value the types definition
     *
     * @Slumber\AsMap(
     *      @Slumber\AsObject(TypeDefinition::class)
     * )
     */
    private $definitions = [];

    /**
     * @return string
     */
    public function getSwagger()
    {
        return $this->swagger;
    }

    /**
     * @param string $swagger
     *
     * @return $this
     */
    public function setSwagger($swagger)
    {
        $this->swagger = $swagger;

        return $this;
    }

    /**
     * @return Info
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param Info $info
     *
     * @return $this
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     *
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     *
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;

        return $this;
    }

    /**
     * @return \PeekAndPoke\Component\Rip\DomainModel\Swagger2\Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param \PeekAndPoke\Component\Rip\DomainModel\Swagger2\Tag[] $tags
     *
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return \PeekAndPoke\Component\Rip\DomainModel\Swagger2\ResourcePath[][]
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * @param \PeekAndPoke\Component\Rip\DomainModel\Swagger2\ResourcePath[][] $paths
     *
     * @return $this
     */
    public function setPaths($paths)
    {
        $this->paths = $paths;

        return $this;
    }

    /**
     * @param string       $uriPattern
     * @param string       $httpMethod
     * @param ResourcePath $path
     *
     * @return $this
     */
    public function addPath($uriPattern, $httpMethod, ResourcePath $path)
    {
        $this->paths[$uriPattern][$httpMethod] = $path;

        return $this;
    }

    /**
     * @return \PeekAndPoke\Component\Rip\DomainModel\Swagger2\TypeDefinition[]
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * @param \PeekAndPoke\Component\Rip\DomainModel\Swagger2\TypeDefinition[] $definitions
     *
     * @return $this
     */
    public function setDefinitions($definitions)
    {
        $this->definitions = $definitions;

        return $this;
    }

    /**
     * @param string $ref
     *
     * @return array
     */
    public function getDefinitionByRef($ref)
    {
        $parts = explode('/', $ref);

//        var_dump($ref);

        $name = $parts[2];

        return [$name, $this->definitions[$name]];
    }
}
