<?php
namespace Flowmailer\API;

use Exception;
use Psr\SimpleCache\CacheInterface;

class ArrayCachePool implements CacheInterface {
    protected array $cache = [];

    public function has(string $key): bool {
        return array_key_exists($key, $this->cache);
    }

    public function get(string $key, mixed $default = null): mixed {
        if($this->has($key)) {
            return $this->cache[$key];
        }

        return $default;
    }

    public function set(string $key, mixed $value, \DateInterval|int|null $ttl = null): bool {
        $this->cache[$key] = $value;

        if($ttl !== null) {
            throw new Exception('ttl is not supported');
        }

        return true;
    }

    public function delete(string $key): bool {
        throw new Exception('Not implemented');
    }

    public function clear(): bool {
        throw new Exception('Not implemented');
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable {
        throw new Exception('Not implemented');
    }

    public function setMultiple(iterable $values, \DateInterval|int|null $ttl = null): bool {
        throw new Exception('Not implemented');
    }

    public function deleteMultiple(iterable $keys): bool {
        throw new Exception('Not implemented');
    }
}
