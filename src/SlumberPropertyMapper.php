<?php
/**
 * Created by gerk on 01.10.16 18:23
 */

namespace PeekAndPoke\Component\Rip;

use PeekAndPoke\Component\MetaCore\Builder;
use PeekAndPoke\Component\MetaCore\DefaultPropertyMapper;
use PeekAndPoke\Component\MetaCore\DomainModel\Docs\Doc;
use PeekAndPoke\Component\MetaCore\DomainModel\Property;
use PeekAndPoke\Component\MetaCore\DomainModel\Type;
use PeekAndPoke\Component\MetaCore\DomainModel\TypeRef;
use PeekAndPoke\Component\MetaCore\DomainModel\Visibility;
use PeekAndPoke\Component\Slumber\Annotation\PropertyMappingMarker;
use PeekAndPoke\Component\Slumber\Annotation\Slumber;
use PeekAndPoke\Component\Slumber\Core\LookUp\EntityConfigReader;


/**
 * SlumberPropertyMapper
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class SlumberPropertyMapper extends DefaultPropertyMapper
{
    /** @var EntityConfigReader */
    private $reader;

    /**
     * @param EntityConfigReader $reader
     */
    public function __construct(EntityConfigReader $reader)
    {
        parent::__construct();

        $this->reader = $reader;
    }

    /**
     * @param Builder             $builder
     * @param \ReflectionProperty $property
     *
     * @return Property
     */
    public function mapProperty(Builder $builder, \ReflectionProperty $property)
    {
        $docBlock = $this->readDocBlock($property);
        $varTag   = $this->getVarTag($docBlock);

        $config = $this->reader->getEntityConfig($property->getDeclaringClass());

        $slumberProperty = $config->getMarkedPropertyByName($property->name);

        if ($slumberProperty === null) {
            throw new \RuntimeException("Could not get Slumber property {$property->class->name}::{$property->name}");
        }

        $slumberMarker   = $slumberProperty->marker;

        return new Property(
            $property->getName(),
            $this->mapType($builder, $slumberMarker),
            Visibility::fromReflection($property),
            $this->isNullable($varTag->getType()),
            new Doc(
                (string) $docBlock->getSummary(),
                (string) $docBlock->getDescription()
            )
        );
    }

    /**
     * @param Builder               $builder
     * @param PropertyMappingMarker $marker
     *
     * @return TypeRef
     */
    private function mapType(Builder $builder, PropertyMappingMarker $marker)
    {
        if ($marker instanceof Slumber\AsBool) {
            return Type::boolean()->ref();
        }

        if ($marker instanceof Slumber\AsDecimal) {
            return Type::double()->ref();
        }

        if ($marker instanceof Slumber\AsInteger) {
            return Type::int()->ref();
        }

        if ($marker instanceof Slumber\AsString) {
            return Type::string()->ref();
        }

        ////  DATETIME  ////////////////////////////////////////////////////////////////////////////////////////////////////////

        if ($marker instanceof Slumber\AsLocalDate) {
            return Type::localDateTime()->ref();
        }

        if ($marker instanceof Slumber\AsSimpleDate) {
            return Type::dateTime()->ref();
        }

        ////  OBJECTS / ENUMS  ////////////////////////////////////////////////////////////////////////////////////////////////////////

        if ($marker instanceof Slumber\AsEnum) {
            return $builder->buildForClass(
                new \ReflectionClass($marker->getValue())    // $marker->getValue() being a valid class name is invariant
            )->ref();
        }

        if ($marker instanceof Slumber\AsObject) {
            return $builder->buildForClass(
                new \ReflectionClass($marker->getValue())    // $marker->getValue() being a valid class name is invariant
            )->ref();
        }

        ////  COLLECTIONS  ////////////////////////////////////////////////////////////////////////////////////////////////////////////

        if ($marker instanceof Slumber\AsMap) {
            return Type::map(
                Type::string()->ref(),
                $this->mapType($builder, $marker->getValue()) // $slumberMarker->value being IPropertyMappingMarker is invariant
            )->ref();
        }

        if ($marker instanceof Slumber\AsList) {
            return Type::list_(
                $this->mapType($builder, $marker->getValue()) // $slumberMarker->value being IPropertyMappingMarker is invariant
            )->ref();
        }

        // needs to be checked as last, since AsMap, AsList, AsKeyValue inherit from it
        if ($marker instanceof Slumber\AsCollection) {
            return Type::map(
                Type::string()->ref(),
                $this->mapType($builder, $marker->getValue()) // $slumberMarker->value being IPropertyMappingMarker is invariant
            )->ref();
        }

        ////  DEFAULT  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        return Type::any()->ref();
    }
}
