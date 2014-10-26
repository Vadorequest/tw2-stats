<?php

/**
 * This is the model class for table "village".
 *
 * The followings are the available columns in table 'village':
 * @property string $id
 * @property integer $beginner_protection
 * @property integer $character_id
 * @property string $character_name
 * @property integer $character_points
 * @property string $name
 * @property integer $points
 * @property string $province_name
 * @property integer $tribe_id
 * @property string $tribe_name
 * @property integer $tribe_points
 * @property string $tribe_tag
 * @property integer $x
 * @property integer $y
 */
class Village extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
            if ( strlen($this->scenario)==0 ) {
                $this->scenario = 'village_'.Yii::app()->controller->world;
            }
		return $this->scenario;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, beginner_protection, name, points, province_name, x, y', 'required'),
			array('beginner_protection, character_id, character_points, points, tribe_id, tribe_points, x, y', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>10),
			array('character_name, province_name, tribe_name', 'length', 'max'=>32),
			array('name', 'length', 'max'=>64),
			array('tribe_tag', 'length', 'max'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, beginner_protection, character_id, character_name, character_points, name, points, province_name, tribe_id, tribe_name, tribe_points, tribe_tag, x, y', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'beginner_protection' => 'Beginner Protection',
			'character_id' => 'Character',
			'character_name' => 'Character Name',
			'character_points' => 'Character Points',
			'name' => 'Name',
			'points' => 'Points',
			'province_name' => 'Province Name',
			'tribe_id' => 'Tribe',
			'tribe_name' => 'Tribe Name',
			'tribe_points' => 'Tribe Points',
			'tribe_tag' => 'Tribe Tag',
			'x' => 'X',
			'y' => 'Y',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('beginner_protection',$this->beginner_protection);
		$criteria->compare('character_id',$this->character_id);
		$criteria->compare('character_name',$this->character_name,true);
		$criteria->compare('character_points',$this->character_points);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('points',$this->points);
		$criteria->compare('province_name',$this->province_name,true);
		$criteria->compare('tribe_id',$this->tribe_id);
		$criteria->compare('tribe_name',$this->tribe_name,true);
		$criteria->compare('tribe_points',$this->tribe_points);
		$criteria->compare('tribe_tag',$this->tribe_tag,true);
		$criteria->compare('x',$this->x);
		$criteria->compare('y',$this->y);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Village the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
