<?php
namespace RazonYang\Yii2\Setting\Tests;

use RazonYang\Yii2\Setting\Manager;

class TestManager extends Manager
{
    public $settings = [];

    protected function load(): array
    {
        return $this->settings;
    }
}
