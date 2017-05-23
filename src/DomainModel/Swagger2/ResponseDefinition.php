<?php
/**
 * Created by gerk on 20.09.16 14:34
 */

namespace PeekAndPoke\Component\Rip\DomainModel\Swagger2;

use PeekAndPoke\Component\Slumber\Annotation\Slumber;


/**
 * ResponseDefinition
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class ResponseDefinition
{
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
    private $schema;

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
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param TypeReference $schema
     *
     * @return $this
     */
    public function setSchema(TypeReference $schema)
    {
        $this->schema = $schema;

        return $this;
    }
}
