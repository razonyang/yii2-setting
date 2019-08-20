<?php
namespace RazonYang\Yii2\Setting;

use yii\base\Component;
use yii\caching\CacheInterface;
use yii\di\Instance;
use yii\mutex\Mutex;

/**
 * Manager is the base manager.
 */
abstract class Manager extends Component implements ManagerInterface
{
    /**
     * @var CacheInterface $cache
     */
    public $cache = 'cache';

    /**
     * @var bool $enableCache whether enable caching.
     */
    public $enableCache = true;

    /**
     * @var Mutex $mutex
     */
    public $mutex = 'mutex';
    
    /**
     * @var string $cacheKey
     */
    public $cacheKey = self::class;

    /**
     * @var int $duration
     */
    public $duration = 600;

    public function init()
    {
        parent::init();

        $this->cache = Instance::ensure($this->cache, CacheInterface::class);
        $this->mutex = Instance::ensure($this->mutex, Mutex::class);
    }

    private $data;

    public function get(string $id, ?string $defaultValue = null): ?string
    {
        $data = $this->getAll();
        return $data[$id] ?? $defaultValue;
    }

    public function getAll(): array
    {
        if ($this->data !== null) {
            return $this->data;
        }

        // retrieves from cache
        if ($this->enableCache && ($this->data = $this->cache->get($this->cacheKey)) !== false) {
            return $this->data;
        }

        // retrieves all data
        $this->data = $this->load();
            
        // cache
        if ($this->enableCache) {
            $lock = $this->cacheKey;
            // acquire lock avoid concurrence
            if ($this->mutex->acquire($lock, 0)) {
                $this->cache->set($this->cacheKey, $this->data, $this->duration);
            }
        }
        
        return $this->data;
    }
    
    /**
     * Loads all data as array that mapping from id to value.
     *
     * @return array
     */
    abstract protected function load(): array;

    public function flushCache(): bool
    {
        $this->data = null;
        // flush cache
        return $this->cache->delete($this->cacheKey);
    }
}
