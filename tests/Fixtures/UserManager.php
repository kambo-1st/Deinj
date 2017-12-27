<?php

namespace Kambo\Tests\Deinj\Fixtures;

/**
 * Fixture class UserManager - stub for the testing purpose
 *
 * @author  Bohuslav Simek <bohuslav@simek.si>
 * @license MIT
 */
class UserManager
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function register($email, $password) : bool
    {
        // The user just registered, we create his account
        // ...

        // We send him an email to say hello!
        $this->mailer->mail($email, 'Hello and welcome!');

        return true;
    }
}
