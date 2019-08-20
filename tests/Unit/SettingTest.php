<?php
namespace RazonYang\Yii2\Setting\Tests\Unit;

use Codeception\Test\Unit;
use RazonYang\Yii2\Setting\Model\Setting;

class SettingTest extends Unit
{
    /**
     * @dataProvider dataProviderValidateValue
     */
    public function testValidateValue(string $id, string $value, string $rules, bool $hasErrors)
    {
        $setting = new Setting([
            'id' => $id,
            'value' => $value,
            'rules' => $rules,
        ]);
        $setting->validateValue('value');
        $this->assertSame($hasErrors, $setting->hasErrors());
    }

    public function dataProviderValidateValue(): array
    {
        return [
            ['name', '', '', false],
            ['name', '', '[["required"]]', true],
            ['name', 'foo', '[["required"]]', false],
            ['name', '1', '[["number"]]', false],
            ['name', 'foo', '[["number"]]', true],
        ];
    }
}
