<?php

namespace Kambo\Deinj;

use Psr\Container\ContainerInterface;
use Kambo\Deinj\Exception\NotFoundException;

/**
 * Simple dependency injection container.
 *
 * @author  Bohuslav Simek <bohuslav@simek.si>
 * @license MIT
 */
final class Container implements ContainerInterface
{
    private $instances = [];
    private $items = [];

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for **this** identifier.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if (!$this->hasEntry($id)) {
            throw new NotFoundException('Entry '.$id.' does not exists.');
        }

        if (!isset($this->instances[$id])) {
            $this->instances[$id] = $this->createInstance($id);
        }

        return $this->instances[$id];
    }

    /**
     * Check if the container can return an entry for the given identifier.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool Returns true if the container can return an entry for the given identifier.
     *              Returns false otherwise.
     */
    public function has($id)
    {
        return $this->hasEntry($id);
    }

    /**
     * Set entry into the container.
     *
     * @param string $id    Identifier of the entry to look for.
     * @param mixed  $entry Entry which should be returned
     *
     * @return self Instance of the self for the fluent interface.
     */
    public function set($id, $entry) : Container
    {
        unset($this->instances[$id]);

        $this->items[$id] = $entry;

        return $this;
    }

    // ------------ PRIVATE METHODS

    /**
     * Create instance of the class
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return mixed Instance of the entry
     */
    private function createInstance(string $id)
    {
        $factory = $this->items[$id];

        return $factory($this);
    }

    /**
     * Check if the container can return an entry for the given identifier.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool Returns true if the container can return an entry for the given identifier.
     *              Returns false otherwise.
     */
    private function hasEntry(string $id) : bool
    {
        return isset($this->items[$id]) ? true : false;
    }
}
