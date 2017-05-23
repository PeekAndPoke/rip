<?php
/**
 * File was created 15.10.2015 17:27
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
namespace PeekAndPoke\Component\Rip\DomainModel\Swagger2;

use PeekAndPoke\Component\Slumber\Annotation\Slumber;


/**
 * TypeDefinition
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class TypeDefinition
{
    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $description;

    /**
     * @var string[]
     *
     * @Slumber\AsList(@Slumber\AsString())
     */
    private $required = [];

    /**
     * @var Property[]
     *
     * @Slumber\AsMap(
     *      @Slumber\AsObject(Property::class)
     * )
     */
    private $properties = [];

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
     * The names of the properties that are required
     *
     * @return \string[]
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param \string[] $required
     *
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param Property[] $properties
     *
     * @return $this
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;

        return $this;
    }
}
