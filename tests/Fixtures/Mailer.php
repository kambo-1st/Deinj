<?php

namespace Kambo\Tests\Deinj\Fixtures;

/**
 * Fixture class Mailer - stub for the testing purpose
 *
 * @author  Bohuslav Simek <bohuslav@simek.si>
 * @license MIT
 */
class Mailer
{
    private $transport;

    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    public function mail($recipient, $content)
    {
        // send an email to the recipient
        $this->transport->send($recipient, $content);
    }
}
