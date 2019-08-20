<?php
namespace RazonYang\Yii2\Setting\Migration;

use RazonYang\Yii2\Setting\DbManager;
use yii\base\InvalidConfigException;
use yii\db\Migration;
use Yii;

/**
 * Class M190725110154Setting
 */
class M190725110154Setting extends Migration
{
    /**
     * @var DbManager[] Targets to create log table for
     */
    private $managers = [];

    /**
     * @throws InvalidConfigException
     * @return DbManager[]
     */
    protected function getManagers()
    {
        if ($this->managers === []) {
            foreach (Yii::$app->getComponents() as $component) {
                try {
                    $component = Yii::createObject($component);
                    if ($component instanceof DbManager) {
                        $this->managers[] = $component;
                    }
                } catch (\Throwable $e) {
                    Yii::error($e, __METHOD__);
                }
            }

            if ($this->managers === []) {
                throw new InvalidConfigException('You should configure setting manager component before executing this migration.');
            }
        }

        return $this->managers;
    }

    public function safeUp()
    {
        foreach ($this->getManagers() as $manager) {
            $tableOptions = null;
            if ($manager->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $this->db = $manager->db;
            $this->createTable($manager->settingTable, [
                'id' => $this->string(32)->notNull()->comment('ID'),
                'description' => $this->string()->notNull()->comment('description'),
                'value' => $this->text()->notNull()->comment('Value'),
                'rules' => $this->text()->notNull()->comment('Validate Rules'),
                'is_secret' => $this->tinyInteger()->notNull()->defaultValue(0)->comment('Is Secret'),
                'create_time' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create Time'),
                'update_time' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update Time'),
            ], $tableOptions);

            $this->addPrimaryKey('setting_pk', $manager->settingTable, ['id']);
        }
    }

    public function safeDown()
    {
        foreach ($this->getManagers() as $manager) {
            $this->db = $manager->db;
            $this->dropTable($manager->settingTable);
        }

        return true;
    }
}
