<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Likes is a model behind 
 */
class Likes extends ActiveRecord
{
	public static function tableName(){
		return '{{likes}}';
	}
}