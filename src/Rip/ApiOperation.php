<?php
/**
 * Created by gerk on 19.09.16 12:38
 */

namespace PeekAndPoke\Component\Rip\Rip;

use Doctrine\Common\Annotations\Annotation;


/**
 * ApiOperation
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 *
 * @property-read $value General description for this api endpoint
 *
 * @Annotation
 * @Annotation\Target("METHOD")
 */
class ApiOperation extends Annotation
{
    /**
     * @var string The type of the request body
     */
    public $request;

    /**
     * @var array Key-value-pair with route param names and their descriptions
     */
    public $params = [];
}
