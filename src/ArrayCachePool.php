<?php
namespace Flowmailer\API;

use Exception;
use Psr\SimpleCache\CacheInterface;

class ArrayCachePool implements CacheInterface {
    protected array $cache = [];

    public function has(string $key): bool {
        if(array_key_exists($key, $this->cache)) {
            if($this->cache[$key]['ttl'] === null || $this->cache[$key]['ttl'] <= time()) {
                return true;
            }
            else {
                unset($this->cache[$key]);
            }
        }
        return false;
    }

    public function get(string $key, mixed $default = null): mixed {
        if($this->has($key)) {
            if($this->cache[$key]['ttl'] !== null && $this->cache[$key]['ttl'] <= time()) {
                unset($this->cache[$key]);
                return $default;
            }

            return $this->cache[$key]['value'];
        }

        return $default;
    }

    public function set(string $key, mixed $value, \DateInterval|int|null $ttl = null): bool {
        if($ttl instanceof \DateInterval) {
            $ttl = (new \DateTime())->add($ttl)->getTimestamp();
        }
        elseif($ttl !== null) {
            $ttl = time() + $ttl;
        }

        $this->cache[$key] = [
            'value' => $value,
            'ttl' => $ttl,
        ];

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
