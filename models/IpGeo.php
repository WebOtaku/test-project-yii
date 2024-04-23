<?php

namespace app\models;

use stdClass;
use Yii;
use yii\base\Model;


/**
 * Модель представляющая данные о местоположении IP-адреса
 * @property string|null $geoplugin_countryName
 * @property string|null $geoplugin_regionName
 * @property string|null $geoplugin_city
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
        ];
    }

    public function fields()
    {
        return [
            'country' => 'geoplugin_countryName',
            'region' => 'geoplugin_regionName',
            'city' => 'geoplugin_city',
        ];
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $arr = parent::toArray($fields, $expand, $recursive);

        foreach ($arr as $key => $value) {
            if ($value === "") {
                $arr[$key] = null;
            }
        }

        return $arr;
    }
}
