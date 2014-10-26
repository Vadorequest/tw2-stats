<?php

/**
 * This is the model class for table "history_tribe".
 *
 * The followings are the available columns in table 'history_tribe':
 * @property string $id
 * @property integer $date
 * @property integer $tribe_id
 * @property integer $rank
 * @property integer $points
 * @property integer $villages
 * @property integer $bash_points_def
 * @property integer $bash_points_off
 * @property integer $bash_points_total
 * @property integer $members
 */
class HistoryTribe extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
            if ( strlen($this->scenario)==0 ) {
                $this->scenario = 'history_tribe_'.Yii::app()->controller->world;
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
			array('date, tribe_id, rank, points, villages, bash_points_def, bash_points_off, bash_points_total, members', 'required'),
			array('date, tribe_id, rank, points, villages, bash_points_def, bash_points_off, bash_points_total, members', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, tribe_id, rank, points, villages, bash_points_def, bash_points_off, bash_points_total, members', 'safe', 'on'=>'search'),
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
			'tribe_id' => 'Tribe',
			'rank' => 'Rank',
			'points' => 'Points',
			'villages' => 'Villages',
			'bash_points_def' => 'Bash Points Def',
			'bash_points_off' => 'Bash Points Off',
			'bash_points_total' => 'Bash Points Total',
			'members' => 'Members',
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
		$criteria->compare('tribe_id',$this->tribe_id);
		$criteria->compare('rank',$this->rank);
		$criteria->compare('points',$this->points);
		$criteria->compare('villages',$this->villages);
		$criteria->compare('bash_points_def',$this->bash_points_def);
		$criteria->compare('bash_points_off',$this->bash_points_off);
		$criteria->compare('bash_points_total',$this->bash_points_total);
		$criteria->compare('members',$this->members);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HistoryTribe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
