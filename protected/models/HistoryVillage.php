<?php

/**
 * This is the model class for table "history_village".
 *
 * The followings are the available columns in table 'history_village':
 * @property string $id
 * @property integer $date
 * @property integer $village_id
 * @property integer $character_id
 * @property string $character_name
 * @property integer $points
 * @property integer $tribe_id
 * @property string $tribe_name
 * @property string $tribe_tag
 */
class HistoryVillage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
            if ( strlen($this->scenario)==0 ) {
                $this->scenario = 'history_village_'.Yii::app()->controller->world;
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
			array('date, village_id, points', 'required'),
			array('date, village_id, character_id, points, tribe_id', 'numerical', 'integerOnly'=>true),
			array('character_name, tribe_name', 'length', 'max'=>32),
			array('tribe_tag', 'length', 'max'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, village_id, character_id, character_name, points, tribe_id, tribe_name, tribe_tag', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
			'village_id' => 'Village',
			'character_id' => 'Character',
			'character_name' => 'Character Name',
			'points' => 'Points',
			'tribe_id' => 'Tribe',
			'tribe_name' => 'Tribe Name',
			'tribe_tag' => 'Tribe Tag',
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
		$criteria->compare('date',$this->date);
		$criteria->compare('village_id',$this->village_id);
		$criteria->compare('character_id',$this->character_id);
		$criteria->compare('character_name',$this->character_name,true);
		$criteria->compare('points',$this->points);
		$criteria->compare('tribe_id',$this->tribe_id);
		$criteria->compare('tribe_name',$this->tribe_name,true);
		$criteria->compare('tribe_tag',$this->tribe_tag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HistoryVillage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
