<?php

namespace app\models;

use stdClass;
use Yii;
use yii\base\Model;


/**
 * Модель представляющая данные о местоположении IP-адреса
 * из ответа от сервиса www.geoplugin.net
 * 
 * @property string|null $geoplugin_countryName страна
 * @property string|null $geoplugin_regionName регион
 * @property string|null $geoplugin_city город
 */
class IpGeo extends Model
{
    public $geoplugin_countryName;
    public $geoplugin_regionName;
    public $geoplugin_city;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['geoplugin_countryName', 'geoplugin_regionName', 'geoplugin_city'], 'string', 'max' => 255],
            [['geoplugin_countryName', 'geoplugin_regionName', 'geoplugin_city'], 'filter', 'filter' => function ($value) {
                return ($value === '') ? null : $value;
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'country' => 'geoplugin_countryName',
            'region' => 'geoplugin_regionName',
            'city' => 'geoplugin_city',
        ];
    }
}
