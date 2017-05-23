<?php
/**
 * Created by gerk on 20.09.16 17:00
 */

namespace PeekAndPoke\Component\Rip\Rip;

use Doctrine\Common\Annotations\Annotation;


/**
 * Api
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 *
 * @property-read $value The name of the Api-group
 *
 * @Annotation
 * @Annotation\Target("CLASS")
 */
class Api extends Annotation
{
    /** @var string Description for the Api-group */
    public $description = '';
}
