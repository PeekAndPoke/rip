<?php
/**
 * File was created 15.10.2015 17:22
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
namespace PeekAndPoke\Component\Rip\DomainModel\Swagger2;

use PeekAndPoke\Component\Slumber\Annotation\Slumber;

/**
 * Tag
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class Tag
{
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
     * @param string $name
     * @param string $description
     *
     * @return static
     */
    public static function from($name, $description)
    {
        $obj = new static;

        $obj->name = $name;
        $obj->description = $description;

        return $obj;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
