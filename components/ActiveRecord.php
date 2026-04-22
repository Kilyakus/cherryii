<?php
namespace yii\cherryii\components;

use Yii;
use yii\db\Connection;

/**
 * Base active record class for cherryii models
 * @package yii\cherryii\components
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /** @var string  */
    public static $SLUG_PATTERN = '/^[0-9a-z-]{0,128}$/';

    /**
     * Get active query
     * @return ActiveQuery
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * Formats all model errors into a single string
     * @return string
     */
    public function formatErrors()
    {
        $result = '';
        foreach($this->getErrors() as $attribute => $errors) {
            $result .= implode(" ", $errors)." ";
        }
        return $result;
    }

    /**
     * Returns the database connection used by this AR class.
     * Intercepts standard connection to automatically handle missing databases.
     * * @return Connection the database connection used by this AR class.
     * @throws \yii\db\Exception
     */
    public static function getDb()
    {
        $db = parent::getDb();

        try {
            // Принудительно открываем соединение, чтобы отловить ошибку "Unknown database"
            $db->open();
        } catch (\yii\db\Exception $e) {
            // Проверяем, что ошибка именно в отсутствии БД и мы в веб-окружении
            if (strpos($e->getMessage(), 'Unknown database') !== false && Yii::$app instanceof \yii\web\Application) {
                $dsn = $db->dsn;
                // Извлекаем имя базы данных из DSN
                preg_match('/dbname=([^;]*)/', $dsn, $matches);
                $dbName = $matches[1] ?? null;

                if ($dbName) {
                    $request = Yii::$app->request;
                    
                    // Шаг 2: Создание БД, если получено подтверждение
                    if ($request->get('create_missing_db') === $dbName) {
                        // Убираем dbname из строки DSN для подключения к самому серверу
                        $dsnWithoutDb = preg_replace('/dbname=[^;]*;?/', '', $dsn);
                        
                        $tempDb = new Connection([
                            'dsn' => rtrim($dsnWithoutDb, ';'),
                            'username' => $db->username,
                            'password' => $db->password,
                            'charset' => $db->charset,
                        ]);
                        
                        $tempDb->open();
                        $tempDb->createCommand("CREATE DATABASE `$dbName` CHARACTER SET utf8 COLLATE utf8_general_ci")->execute();
                        $tempDb->close();

                        // Очистка URL от параметра создания и редирект
                        $url = $request->getUrl();
                        $url = preg_replace('/([?&])create_missing_db=[^&]*&?/', '$1', $url);
                        $url = rtrim($url, '?&');
                        
                        Yii::$app->getResponse()->redirect($url)->send();
                        exit();
                    } else {
                        // Шаг 1: Вывод минималистичного окна для подтверждения
                        $currentUrl = $request->getUrl();
                        $separator = strpos($currentUrl, '?') !== false ? '&' : '?';
                        $createUrl = $currentUrl . $separator . 'create_missing_db=' . urlencode($dbName);

                        echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Database Required</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f6f8; margin: 0; }
        .window { background: #ffffff; padding: 40px; border-radius: 6px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); text-align: center; max-width: 450px; }
        h2 { color: #2c3e50; font-size: 22px; margin-top: 0; }
        p { color: #5c6873; font-size: 15px; margin-bottom: 25px; line-height: 1.5; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #3498db; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: 500; transition: background 0.2s; }
        .btn:hover { background-color: #2980b9; }
    </style>
</head>
<body>
    <div class='window'>
        <h2>Database Not Found</h2>
        <p>The database <strong>{$dbName}</strong> specified in your configuration does not exist. A new database with this name will be created.</p>
        <a href='{$createUrl}' class='btn'>Create Database</a>
    </div>
</body>
</html>";
                        exit();
                    }
                }
            }
            
            // Если ошибка другого рода или не удалось найти DSN, выбрасываем исключение дальше
            throw $e;
        }

        return $db;
    }
}