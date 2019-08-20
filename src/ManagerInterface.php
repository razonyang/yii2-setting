<?php
namespace RazonYang\Yii2\Setting;

interface ManagerInterface
{
    /**
     * Gets data by the given id.
     *
     * @param string      $id
     * @param null|string $defaultValue
     *
     * @return string|nul returns the data if exists, otherwise default value or null.
     */
    public function get(string $id, ?string $defaultValue = null): ?string;

    /**
     * Gets all data.
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Flushs cache.
     *
     * @return bool
     */
    public function flushCache(): bool;
}
