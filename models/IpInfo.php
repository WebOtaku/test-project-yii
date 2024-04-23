<?php

namespace app\models;

use Yii;

/**
 * Модель представляющая данные о местоположении IP-адреса
 *
 * @property string $ip IP-адрес
 * @property string|null $country страна
 * @property string|null $region регион
 * @property string|null $city город
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
            [['country', 'region', 'city'], 'filter', 'filter' => function($value) {
                return ($value === '') ? null : $value;
            }],
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

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = ['country', 'region', 'city'];
        return $scenarios;
    }


    /**
     * @param string $attribute атрибут проверяемый в настоящее время
     * @param array $params дополнительные пары имя-значение, заданное в правиле
     */
    public function validateIP($attribute, $params) 
    {
        if (!filter_var($this->$attribute, FILTER_VALIDATE_IP)) {
            $this->addError($attribute, 'Введите корректный IP-адресс');
        }
    }
}
