<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Articles is a model behind 
 */
class Comments extends ActiveRecord
{
   public static function tableName(){
		return '{{comments}}';
	}
}
