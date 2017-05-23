<?php
/**
 * Created by gerk on 01.10.16 17:43
 */

namespace PeekAndPoke\Component\Rip;

use PeekAndPoke\Component\MetaCore\PropertyFilter;
use PeekAndPoke\Component\Slumber\Core\LookUp\EntityConfigReader;


/**
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class SlumberPropertyFilter implements PropertyFilter
{
    /** @var EntityConfigReader */
    private $reader;

    /**
     * SlumberPropertyFilter constructor.
     *
     * @param EntityConfigReader $reader
     */
    public function __construct(EntityConfigReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * This filter only accepts properties that are marked by Slumber
     *
     * @param \ReflectionProperty $property
     *
     * @return bool
     */
    public function filterProperty(\ReflectionProperty $property)
    {
        $config = $this->reader->getEntityConfig($property->getDeclaringClass());

        return $config->getMarkedPropertyByName($property->getName()) !== null;
    }
}
