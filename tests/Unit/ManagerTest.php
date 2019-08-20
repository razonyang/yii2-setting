<?php
namespace RazonYang\Yii2\Setting\Tests\Unit;

use Codeception\Test\Unit;
use RazonYang\Yii2\Setting\Tests\TestManager;

class ManagerTest extends Unit
{
    private function createManager(array $settings, $enableCache = true): TestManager
    {
        return new TestManager([
            'settings' => $settings,
            'cacheKey' => uniqid(),
            'enableCache' => $enableCache,
        ]);
    }

    /**
     * @dataProvider dataProviderGet
     */
    public function testGet(array $settings, string $id, ?string $expected): void
    {
        // empty array
        $manager = $this->createManager($settings, false);
        $this->assertSame($expected, $manager->get($id));
    }

    public function dataProviderGet(): array
    {
        return [
            [[], 'name', null],
            [['name' => 'foo'], 'name', 'foo'],
        ];
    }

    public function testGetWithDefaultValue(): void
    {
        $manager = $this->createManager([]);
        $defaultValue = 'default value';
        $this->assertSame($defaultValue, $manager->get(uniqid(), $defaultValue));
    }

    /**
     * @dataProvider dataProviderGetAll
     */
    public function testGetAll(array $settings): void
    {
        $manager = $this->createManager($settings);
        $this->assertCount(count($settings), $manager->getAll());
        foreach ($settings as $id => $value) {
            $this->assertEquals($value, $manager->get($id));
        }

        // create manager using same cache key
        $newManager = new TestManager(['cacheKey' => $manager->cacheKey]);
        $this->assertSame($manager->getAll(), $newManager->getAll());
    }

    public function dataProviderGetAll(): array
    {
        return [
            [[]],
            [['name' => 'foo']],
            [['name' => 'bar', 'age' => 0]],
        ];
    }

    public function testFlushCache(): void
    {
        $settings = ['name' => 'foo'];
        $manager = $this->createManager($settings);
        $this->assertTrue($manager->enableCache);
        $this->assertSame('foo', $manager->get('name'));

        // change settings
        $manager->settings = ['name' => 'bar'];
        $this->assertSame('foo', $manager->get('name'));

        // flush cache
        $this->assertIsBool($manager->flushCache());
        $this->assertSame('bar', $manager->get('name'));
    }
}
