<?php

/**
 * This is part of the ascetik/cacheable package
 *
 * @package    Cacheable
 * @category   Data Transfer Object
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\Cacheable\Instanciable\DTO;

use Ascetik\Cacheable\Types\Cacheable;
use Ascetik\Cacheable\Types\CacheableProperty;
use Ds\Set;

/**
 * Register Instance properties and their values
 * for serialization purpose.
 *
 * @uses Ds\Set
 * @version 1.0.0
 */
class CacheablepropertyRegistry implements Cacheable
{
    /**
     * Reference container
     *
     * @var Set<CacheableProperty>
     */
    private Set $container;

    public function __construct(iterable $content = [])
    {
        $this->container = new Set($content);
    }

    public function assign(int $amount): void
    {
        $this->container->allocate($amount);
    }

    /**
     * @return Set<CacheableProperty>
     */
    public function list(): Set
    {
        return $this->container->copy();
    }

    public function push(CacheableProperty ...$reference)
    {
        $this->container->add(...$reference);
    }

    public function serialize(): string
    {
        return serialize($this->container);
    }

    public function unserialize(string $data): void
    {
        /** @var CacheableProperty[] $references */
        $references = unserialize($data);
        $this->container = new Set($references);
    }
}
