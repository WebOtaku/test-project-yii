<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ip_info".
 *
 * @property string $ip
 * @property string|null $country
 * @property string|null $region
 * @property string|null $city
 */
class IpInfo extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ip_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip'], 'required'],
            [['ip', 'country', 'region', 'city'], 'string', 'max' => 255],
            [['ip'], 'unique'],
            [['ip'], 'validateIP'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ip' => 'IP',
            'country' => 'Страна',
            'region' => 'Регион',
            'city' => 'Город',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = ['country', 'region', 'city'];
        return $scenarios;
    }

    public function validateIP($attribute, $params) 
    {
        if (!filter_var($this->$attribute, FILTER_VALIDATE_IP)) {
            $this->addError($attribute, 'Введите корректный IP-адресс');
        }
    }
}
