<?php
namespace RazonYang\Yii2\Setting\Tests\Unit;

use Codeception\Test\Unit;
use RazonYang\Yii2\Setting\DbManager;
use RazonYang\Yii2\Setting\Tests\Fixture\SettingFixture;

class DbManagerTest extends Unit
{
    private function getDataFile(): string
    {
        return codecept_data_dir() . 'setting.php';
    }

    public function _fixtures()
    {
        return [
            'setting' => [
                'class' => SettingFixture::className(),
                'dataFile' => $this->getDataFile()
            ]
        ];
    }

    public function testLoad(): void
    {
        $data = require $this->getDataFile();
        $manager = new DbManager();
        $settings = $manager->load();
        $this->assertCount(count($data), $settings);
        foreach ($data as $id => $fields) {
            $this->assertArrayHasKey($id, $settings);
            $this->assertSame($fields['value'], $settings[$id]);
        }
    }
}
