<?php

/**
 * This is the model class for table "tribe".
 *
 * The followings are the available columns in table 'tribe':
 * @property string $id
 * @property integer $rank
 * @property integer $points
 * @property integer $villages
 * @property integer $bash_points_def
 * @property integer $bash_points_off
 * @property integer $bash_points_total
 * @property integer $members
 * @property string $name
 * @property string $tag
 */
class Tribe extends CActiveRecord
{
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
            if ( strlen($this->scenario)==0 ) {
                $this->scenario = 'tribe_'.Yii::app()->controller->world;
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
			array('id, rank, points, villages, bash_points_def, bash_points_off, bash_points_total, members, name, tag', 'required'),
			array('rank, points, villages, bash_points_def, bash_points_off, bash_points_total, members', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>10),
			array('name', 'length', 'max'=>32),
			array('tag', 'length', 'max'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rank, points, villages, bash_points_def, bash_points_off, bash_points_total, members, name, tag', 'safe', 'on'=>'search'),
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
			'rank' => 'Rank',
			'points' => 'Points',
			'villages' => 'Villages',
			'bash_points_def' => 'Bash Points Def',
			'bash_points_off' => 'Bash Points Off',
			'bash_points_total' => 'Bash Points Total',
			'members' => 'Members',
			'name' => 'Name',
			'tag' => 'Tag',
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
		$criteria->compare('rank',$this->rank);
		$criteria->compare('points',$this->points);
		$criteria->compare('villages',$this->villages);
		$criteria->compare('bash_points_def',$this->bash_points_def);
		$criteria->compare('bash_points_off',$this->bash_points_off);
		$criteria->compare('bash_points_total',$this->bash_points_total);
		$criteria->compare('members',$this->members);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('tag',$this->tag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tribe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function get_name()
        {
            return '['.$this->tag.'] '.$this->name;
        }
}
