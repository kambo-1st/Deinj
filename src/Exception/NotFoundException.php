<?php

namespace Kambo\Deinj\Exception;

use Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * No entry was found in the container exception.
 *
 * @author  Bohuslav Simek <bohuslav@simek.si>
 * @license MIT
 */
class NotFoundException extends Exception implements NotFoundExceptionInterface
{

}
