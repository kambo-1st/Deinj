<?php

namespace Kambo\Tests\Deinj;

use PHPUnit\Framework\TestCase;

use Kambo\Deinj\Container;
use Kambo\Deinj\Exception\NotFoundException;

use Kambo\Tests\Deinj\Fixtures\Transport;
use Kambo\Tests\Deinj\Fixtures\Mailer;
use Kambo\Tests\Deinj\Fixtures\UserManager;

/**
 * Unit tests for the class Kambo\Deinj\Container
 *
 * @author  Bohuslav Simek <bohuslav@simek.si>
 * @license MIT
 */
class ContainerTest extends TestCase
{
    /**
     * Tests "has" method - entry "transport" does exists
     *
     * @return void
     */
    public function testHasEntryExists()
    {
        $container = new Container();

        $container->set(
            'transport',
            function () {
                return new Transport();
            }
        );

        $this->assertTrue($container->has('transport'));
    }

    /**
     * Tests "has" method - entry "transport" does not exists
     *
     * @return void
     */
    public function testHasEntryDoesNotExists()
    {
        $container = new Container();
        $this->assertFalse($container->has('transport'));
    }

    /**
     * Tests "get" method - entry "transport" exists
     *
     * @return void
     * @throws NotFoundException
     * @throws \Kambo\Deinj\ContainerExceptionInterface
     */
    public function testGetExists()
    {
        $container = new Container();

        $container->set(
            'transport',
            function () {
                return new Transport();
            }
        );

        $this->assertInstanceOf(Transport::class, $container->get('transport'));
    }

    /**
     * Tests "get" method - entry "transport" does not exists, an exception must be thrown.
     *
     * @return void
     * @throws NotFoundException
     * @throws \Kambo\Deinj\ContainerExceptionInterface
     */
    public function testGetDoesNotExists()
    {
        $this->expectException(NotFoundException::class);

        $container = new Container();
        $container->get('transport');
    }

    /**
     * Tests "get" method - injecting a multiple classes.
     *
     * @return void
     * @throws NotFoundException
     * @throws \Kambo\Deinj\ContainerExceptionInterface
     */
    public function testGetComplexClass()
    {
        $container = new Container();

        $container->set(
            'transport',
            function () {
                return new Transport();
            }
        );

        $container->set(
            'mailer',
            function ($container) {
                return new Mailer($container->get('transport'));
            }
        );

        $container->set(
            'userManager',
            function ($container) {
                return new UserManager($container->get('mailer'));
            }
        );

        $userManager = $container->get('userManager');

        $this->assertTrue($userManager->register('username', 'password'));
    }
}
