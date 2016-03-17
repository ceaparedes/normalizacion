<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{

  public static function getDb()
      {
          // use the "db2" application component
          return \Yii::$app->dbusuario;
      }

  public static function tableName()
  {
    return 'usuarios';

  }



    /* aqui estan los usuarios por defecto, eliminar cuando este implementada la conexion con la base de datos.*/
    private static $users = [


     ];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;

        $usuario = self::find()->where(['rut_us'=>$id])->one();
        if(!count($usuario)){
          return null;
        }
        return new static ($usuario);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $usuario = self::find()->where(['accessToken'=>$token])->one();
        if(!count($usuario)){
          return null;
        }

        return new static($usuario);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $usuario = self::find()->where(['rut_us'=>$username])->one();

        if(!count($usuario)){
          return null;
        }

        return new static($usuario);
    }

    /**
     * @inheritdoc
     */
     public function getId() {
     return $this->rut_us;
 }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password_us)
    {
        return $this->password_us === $password_us;
    }
}
