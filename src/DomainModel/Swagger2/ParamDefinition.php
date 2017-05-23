<?php
/**
 * Created by gerk on 20.09.16 15:21
 */

namespace PeekAndPoke\Component\Rip\DomainModel\Swagger2;

use PeekAndPoke\Component\Slumber\Annotation\Slumber;

/**
 * ParamDefinition
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class ParamDefinition
{
    /**
     * @var string Location of the parameter: "path" or "body"
     *
     * @Slumber\AsString()
     */
    private $in;

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $name;

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $description;

    /**
     * @var bool
     *
     * @Slumber\AsBool()
     */
    private $required = false;

    /**
     * @var string
     *
     * TODO: what is this for ?
     *
     * @Slumber\AsString()
     */
    private $type = 'ref';

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $default = '';

    /**
     * @var TypeReference
     *
     * @Slumber\AsObject(TypeReference::class)
     */
    private $schema;

    /**
     * @return string
     */
    public function getIn()
    {
        return $this->in;
    }

    /**
     * @param string $in
     *
     * @return $this
     */
    public function setIn($in)
    {
        $this->in = $in;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     *
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param string $default
     *
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @return TypeReference
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param TypeReference $schema
     *
     * @return $this
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;

        return $this;
    }
}
