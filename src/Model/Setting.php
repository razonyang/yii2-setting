<?php
namespace RazonYang\Yii2\Setting\Model;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\validators\Validator;
use Yii;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property string $id ID
 * @property string $value Value
 * @property int $create_time Create Time
 * @property int $update_time Update Time
 */
class Setting extends ActiveRecord
{
    /**
     * @codeCoverageIgnore
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @codeCoverageIgnore
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
            ],
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function rules()
    {
        return [
            [['value', 'description'], 'required'],
            [['value', 'description'], 'string'],
            [['create_time', 'update_time'], 'integer'],
            ['value', 'validateValue'],
        ];
    }

    public function validateValue($attribute)
    {
        $rules = json_decode($this->rules, true);
        if (!is_array($rules)) {
            return;
        }

        foreach ($rules as $rule) {
            $params = $rule;
            $ruleName = $rule[0];
            unset($params[0]);
            $validator = Validator::createValidator($ruleName, $this, $attribute, $params);
            $validator->validateAttribute($this, $attribute);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'value' => Yii::t('app', $this->description),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function fields()
    {
        return [
            'id',
            'description',
            'value',
            'create_time',
            'update_time',
        ];
    }
}
