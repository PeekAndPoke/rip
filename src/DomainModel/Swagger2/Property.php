<?php
/**
 * File was created 15.10.2015 17:31
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
namespace PeekAndPoke\Component\Rip\DomainModel\Swagger2;

use PeekAndPoke\Component\Slumber\Annotation\Slumber;

/**
 * Property
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class Property
{
    /**
     * @var string
     *
     * @Slumber\AsString(alias="$ref")
     */
    private $ref;

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $type;

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $format;

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $description;

    /**
     * @var TypeReference
     *
     * @Slumber\AsObject(TypeReference::class)
     */
    private $items;

    /**
     * @var TypeReference
     *
     * @Slumber\AsObject(TypeReference::class)
     */
    private $additionalProperties;

    /**
     * @var string[]
     *
     * @Slumber\AsList(@Slumber\AsString())
     */
    private $enum;

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     *
     * @return $this
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

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
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     *
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;

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
     * @return TypeReference
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param TypeReference $items
     *
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return TypeReference
     */
    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
    }

    /**
     * @param TypeReference $additionalProperties
     *
     * @return $this
     */
    public function setAdditionalProperties($additionalProperties)
    {
        $this->additionalProperties = $additionalProperties;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getEnum()
    {
        return $this->enum;
    }

    /**
     * @param \string[] $enum
     *
     * @return $this
     */
    public function setEnum($enum)
    {
        $this->enum = $enum;

        return $this;
    }
}
