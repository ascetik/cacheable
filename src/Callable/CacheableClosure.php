<?php

/**
 * This is part of the ascetik/cacheable package
 *
 * @package    Cacheable
 * @category   Value Object
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\Cacheable\Callable;

use Ascetik\Cacheable\Types\CacheableCall;
use Ascetik\Callapsule\Types\CallableType;
use Ascetik\Callapsule\Values\ClosureCall;
use Closure;
use Opis\Closure\SerializableClosure;

/**
 * Handle and serialize a Closure
 *
 * @uses opis/closure Package
 * @version 1.0.0
 */
class CacheableClosure extends CacheableCall
{
    protected ClosureCall $closure;

    public function __construct(Closure $callable)
    {
        $this->buildWrapper($callable);
    }

    public function serialize(): string
    {
        $wrapper = new SerializableClosure($this->closure->getCallable());
        return serialize($wrapper);
    }

    public function unserialize(string $data): void
    {
        $deserial = unserialize($data);
        $this->buildWrapper($deserial->getClosure());
    }

    protected function getWrapper(): CallableType
    {
        return $this->closure;
    }

    private function buildWrapper(Closure $callable): void
    {
        $this->closure = new ClosureCall($callable);
    }
}
