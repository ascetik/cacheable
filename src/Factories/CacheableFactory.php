<?php

/**
 * This is part of the ascetik/cacheable package
 *
 * @package    Cacheable
 * @category   Factory
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\Cacheable\Factories;

use Ascetik\Cacheable\Callable\CacheableClosure;
use Ascetik\Cacheable\Callable\CacheableInvokable;
use Ascetik\Cacheable\Callable\CacheableMethod;
use Ascetik\Cacheable\Instanciable\CacheableInstance;
use Ascetik\Cacheable\Instanciable\ValueObjects\CacheableCallableProperty;
use Ascetik\Cacheable\Instanciable\ValueObjects\CacheableCustomProperty;
use Ascetik\Cacheable\Instanciable\ValueObjects\CacheableObjectProperty;
use Ascetik\Cacheable\Types\CacheableCall;
use Ascetik\Cacheable\Types\CacheableProperty;
use Closure;
use InvalidArgumentException;

/**
 * Build Cacheable instances
 *
 * @version 1.0.0
 */
class CacheableFactory
{
    /**
     * @throws InvalidArgumentException
     *
     * @return CacheableCall
     */
    public static function wrapCall(callable $callable): CacheableCall
    {
        if (is_array($callable)) {
            return new CacheableMethod(...$callable);
        }

        if ($callable instanceof Closure) {
            return new CacheableClosure($callable);
        }

        if (is_object($callable) && method_exists($callable, '__invoke')) {
            return new CacheableInvokable($callable);
        }
        throw new InvalidArgumentException('No use case matching with given parameters');
    }

    public static function wrapInstance(object $subject): CacheableInstance
    {
        return new CacheableInstance($subject);
    }

    public static function wrapProperty(string $name, mixed $value): CacheableProperty
    {
        return match (true) {
            $value instanceof Closure => new CacheableCallableProperty($name, $value),
            is_object($value) => new CacheableObjectProperty($name, $value),
            default => new CacheableCustomProperty($name, $value)
        };
    }
}
