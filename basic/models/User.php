<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users'; // Assuming the table name is 'user'
    }
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                // Additional logic before saving for new records
            }
            // Additional logic before saving for existing records
            return true;
        }
        return false;
    }
}
