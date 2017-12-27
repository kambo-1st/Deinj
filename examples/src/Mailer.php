<?php

namespace Kambo\Examples\Deinj;

/**
 * Example class Mailer
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
