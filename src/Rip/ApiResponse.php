<?php
/**
 * Created by gerk on 20.09.16 07:15
 */

namespace PeekAndPoke\Component\Rip\Rip;

use Doctrine\Common\Annotations\Annotation;

/**
 * ApiResponse
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 *
 * @Annotation
 * @Annotation\Target("METHOD")
 */
class ApiResponse extends Annotation
{
    /**
     * @var int    Http status code
     */
    public $code;

    /**
     * @var string Http status message
     */
    public $message;

    /**
     * @var string The response type / fqcn
     */
    public $response;

    /**
     * @var string "map", "list", "kv-pairs"
     */
    public $responseContainer;
}
