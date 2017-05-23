<?php
/**
 * File was created 15.10.2015 17:31
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
namespace PeekAndPoke\Component\Rip\DomainModel\Swagger2;

use PeekAndPoke\Component\Slumber\Annotation\Slumber;

/**
 * TypeReference
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class TypeReference
{
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
     * @Slumber\AsString(alias="$ref")
     */
    private $ref;

    /**
     * @var TypeReference
     *
     * @Slumber\AsObject(TypeReference::class)
     */
    private $items;

    /**
     * @param $what
     *
     * @return TypeReference
     */
    public static function toDefinitions($what)
    {
        $obj = new static;
        $obj->ref = '#/definitions/' . $what;

        return $obj;
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
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
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
}
