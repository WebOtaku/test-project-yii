<?php

namespace app\commands;

use app\models\IpGeo;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * IpInfoController реализует функционал CLI приложения 
 */
class IpInfoController extends Controller
{

    public $ip = null;

    public function options($actionID)
    {
        return ['ip'];
    }

    // public function optionAliases()
    // {
    //     return ['m' => 'message'];
    // }

    /**
     * Отображает информацию об IP-адресе в терминале
     * @param string $ip IP-адрес
     * @return int Exit code
     */
    public function actionIndex($ip = null)
    {   
        $error = null;

        if (!isset($ip)) {
            if (isset($this->ip)) {
                $ip = $this->ip;
            } else {
                $error = "Введите IP-адрес";
            }
        }

        if (!isset($error) && !filter_var($ip, FILTER_VALIDATE_IP)) {
            $error = "Введите корректный IP-адрес";
        }

        if (isset($error)) {
            echo $error;
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $ch = curl_init('http://www.geoplugin.net/json.gp?ip=' . $ip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);

        $ipGeo = new IpGeo();

        if ($ipGeo->load((array) $response, '') && $ipGeo->validate()) {
            $message = '';

            foreach ($ipGeo->toArray() as $key => $value) {
                $message .= ucfirst($key) . ": $value \n";
            }

            echo $message;
        }
        
        return ExitCode::OK;
    }
}
