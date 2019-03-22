<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://hyperf.org
 * @document https://wiki.hyperf.org
 * @contact  group@hyperf.org
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace Hyperf\Cache;

use Psr\SimpleCache\CacheInterface;

class Cache implements CacheInterface
{
    protected $driver;

    public function __construct(CacheManager $manager)
    {
        $this->driver = $manager->getDriver();
    }

    public function __call($name, $arguments)
    {
        return $this->driver->{$name}(...$arguments);
    }

    /**
     * @return Driver\DriverInterface
     */
    public function getDriver(): Driver\DriverInterface
    {
        return $this->driver;
    }

    public function get($key, $default = null)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function set($key, $value, $ttl = null)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function delete($key)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function clear()
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function getMultiple($keys, $default = null)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function setMultiple($values, $ttl = null)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function deleteMultiple($keys)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function has($key)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }
}