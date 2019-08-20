<?php
namespace RazonYang\Yii2\Setting;

use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

class DbManager extends Manager
{
    /**
     * @var Connection $db
     */
    public $db = 'db';

    /**
     * @var string $modelClass
     */
    public $settingTable = '{{%setting}}';

    public function init()
    {
        parent::init();

        $this->db = Instance::ensure($this->db, Connection::class);
    }

    public function load(): array
    {
        $tableName = $this->db->quoteTableName($this->settingTable);
        $sql = "SELECT id, value FROM $tableName";
        $rows = $this->db->createCommand($sql)->queryAll();
        return ArrayHelper::map($rows, 'id', 'value');
    }
}
