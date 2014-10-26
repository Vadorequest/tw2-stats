<?php

class ObjectController extends AdminController
{
        public $header = 'Управление объектами';
        public function getMenu() 
        {
            return array(
                array(
                    'label' => 'Все объекты',
                    'url' => array('/admin/object/index'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Новые объекты',
                    'url' => array('/admin/object/index', 'status'=>'0'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Актуальные объекты',
                    'url' => array('/admin/object/index', 'status'=>'1'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                /*array(
                    'label' => 'Посуточные объекты',
                    'url' => array('/admin/object/index', 'daily'=>'1'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),*/
                array(
                    'label' => 'Архив объектов',
                    'url' => array('/admin/object/index', 'status'=>'2'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Удаленные объекты',
                    'url' => array('/admin/object/index', 'status'=>'3'),
                    'icon' => BsHtml::GLYPHICON_LIST,
                ),
                array(
                    'label' => 'Добавить объект',
                    'url' => array('/admin/object/create'),
                    'icon' => BsHtml::GLYPHICON_PLUS_SIGN,
                ),
                array(
                    'label' => 'Обзор объекта',
                    'url' => array('/admin/object/view', 'id'=>$_GET['id']),
                    'icon' => BsHtml::GLYPHICON_EYE_OPEN,
                    'visible' => in_array($this->action->id, array('view', 'update')),
                ),
                array(
                    'label' => 'Редактирование объекта',
                    'url' => array('/admin/object/update', 'id'=>$_GET['id']),
                    'icon' => BsHtml::GLYPHICON_PENCIL,
                    'visible' => $this->action->id=='update',
                ),
            );
        }



        public function loadModel($id)
	{
            $model=Object::model()->findByPk($id);
            if ( $model===null )
                throw new CHttpException(404,'The requested page does not exist.');
            return $model;
	}
        
        
        //
        protected function performAjaxValidation($model)
	{
            if ( isset($_POST['ajax']) && $_POST['ajax']==='object-form' ) {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        
        public function actionIndex()
	{
            $model=new Object('search');
            $model->unsetAttributes();
            
            if ( !isset($_GET['ajax']) ) {
                $cookie = Yii::app()->request->cookies['filter_object']->value;
                if ( $cookie!==null && $_SERVER['QUERY_STRING']!=$cookie ) {
                    $this->redirect(str_replace($_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']).'?'.$cookie);
                }
            }
            
            if ( isset($_GET['status']) ) {
                $model->status = $_GET['status'];
            }
            if ( isset($_GET['daily']) ) {
                $model->daily = 1;
            }
            if( isset($_GET['Object']) ) {
                $model->attributes=$_GET['Object'];
                if ( strlen($_GET['price_from'])!=0 ) {
                    $model->price_from = $_GET['price_from'];
                }
                if ( strlen($_GET['price_to'])!=0 ) {
                    $model->price_to = $_GET['price_to'];
                }
            }
            
            $this->render('index', array(
                'model'=>$model,
            ));
	}
    
        
	public function actionView($id)
	{
            if ( !isset($_GET['dest']) ) {
                $this->render('view', array(
                    'model'=>$this->loadModel($id),
                ));
            } else {
                
                //$filter = Yii::app()->request->cookies['filter_object']->value;
                //if ( $filter===null ) {
                    $cModel = $this->loadModel($id);
                    if ( $_GET['dest']=='prev' ) {
                        if ( !isset($_GET['spec']) ) {
                            $model = Object::model()->find('`id`<'.$id.' ORDER BY `id` DESC');
                        } elseif ( $_GET['spec']=='status' ) {
                            $model = Object::model()->find('`id`<'.$id.' AND `status`='.$cModel->status.' ORDER BY `id` DESC');
                        }
                        if ( $model ) {
                            $this->render('view', array(
                                'model'=>$model,
                            ));
                        } else {
                            Yii::app()->user->setFlash('warning', 'Этот объект является первым в списке, поэтому обратиться к предыдущему нельзя.');
                            $this->redirect($_SERVER['HTTP_REFERER']);
                        }
                    } else {
                        if ( !isset($_GET['spec']) ) {
                            $model = Object::model()->find('`id`>'.$id.' ORDER BY `id` DESC');
                        } elseif ( $_GET['spec']=='status' ) {
                            $model = Object::model()->find('`id`>'.$id.' AND `status`='.$cModel->status.' ORDER BY `id` DESC');
                        }
                        if ( $model ) {
                            $this->render('view', array(
                                'model'=>$model,
                            ));
                        } else {
                            Yii::app()->user->setFlash('warning', 'Этот объект является последним в списке, поэтому обратиться к следующему нельзя.');
                            $this->redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                //} else {
                    
                //}
                
            }
            
            
	}
        
        


	public function actionCreate()
	{
            $model=new Object;
            $model->free_date = date('d.m.Y');
            $model->show_date = date('d.m.Y');
            $model->user_id = Yii::app()->user->id;
            $model->creator_id = Yii::app()->user->id;
            $model->status = 1;

            // $this->performAjaxValidation($model);

            if ( isset($_POST['Object']) ) {
                $model->attributes=$_POST['Object'];
                
                $model->date_create = time();
                $model->origin = 0;
                
                if ( Yii::app()->user->checkAccess('1') && strlen($model->user_id)!=0 ) {
                    
                } else {
                    $model->user_id = Yii::app()->user->id;
                }
                
                if ( $model->free ) {
                    $model->free_date = strtotime($model->free_date);
                }
                if ( $model->show ) {
                    $model->show_date = strtotime($model->show_date);
                }
                
                if ( $model->status!=0 ) {
                    $model->date_admin = time();
                }
                
                $model->_img = CUploadedFile::getInstances($model,'_img');
                
                if( $model->save() ) {
                    foreach($model->_img as $file) {
                        if ( $file->name!='' ) {
                            $imageExtention = pathinfo($file->getName(), PATHINFO_EXTENSION);
                            $imageName      = substr(md5($file->name.microtime()), 0, 28).'.'.$imageExtention;
                            $image = Yii::app()->image->load($file->tempName);
                            $image->save('./uploads/object/'.$imageName);
                            $image->resize(256, 256);
                            $image->save('./uploads/object/preview/'.$imageName);
                            $objectImage = new ObjectImage;
                            $objectImage->object_id = $model->id;
                            $objectImage->img = $imageName;
                            $objectImage->save();
                        }
                    }
                    $this->redirect(array('view','id'=>$model->id));
                }
            }

            $this->render('create', array(
                'model'=>$model,
            ));
	}


	public function actionUpdate($id)
	{
            $model=$this->loadModel($id);
            if ( Yii::app()->user->checkAccess('1') && strlen($model->user_id)!=0 ) {

            } else {
                $model->user_id = Yii::app()->user->id;
            }

            // $this->performAjaxValidation($model);
            
            if ( $model->free_date>0 ) {
                $model->free_date = date('d.m.Y', $model->free_date);
            } else {
                $model->free_date = date('d.m.Y');
            }
            if ( $model->show_date>0 ) {
                $model->show_date = date('d.m.Y', $model->show_date);
            } else {
                $model->show_date = date('d.m.Y');
            }
            
            if ( isset($_POST['Object']) ) {
                $model->attributes=$_POST['Object'];
                
                $model->date_update = time();
                
                if ( Yii::app()->user->checkAccess('1') && strlen($model->user_id)!=0 ) {
                    
                } else {
                    $model->user_id = Yii::app()->user->id;
                }
                
                if ( $model->free ) {
                    $model->free_date = strtotime($model->free_date);
                }
                if ( $model->show ) {
                    $model->show_date = strtotime($model->show_date);
                }
                if ( $model->status!=0 ) {
                    $model->date_admin = time();
                }
                
                $model->_img = CUploadedFile::getInstances($model,'_img');
                
                if( $model->save() ) {
                    if ( count($model->objectImage)!=0 ) {
                        ObjectImage::model()->deleteAll('`object_id`='.$model->id);
                    }
                    
                    foreach($model->_img as $file) {
                        if ( $file->name!='' ) {
                            $imageExtention = pathinfo($file->getName(), PATHINFO_EXTENSION);
                            $imageName      = substr(md5($file->name.microtime()), 0, 28).'.'.$imageExtention;
                            $image = Yii::app()->image->load($file->tempName);
                            //$image->resize(1024, 1024);
                            $image->save('./uploads/object/'.$imageName);
                            $image->resize(256, 256);
                            $image->save('./uploads/object/preview/'.$imageName);
                            $objectImage = new ObjectImage;
                            $objectImage->object_id = $model->id;
                            $objectImage->img = $imageName;
                            $objectImage->save();
                        }
                    }
                    
                    $this->redirect(array('view','id'=>$model->id));
                }
            }

            $this->render('update',array(
                'model'=>$model,
            ));
	}


	public function actionDelete($id)
	{
            //if ( Yii::app()->request->isPostRequest ) {
                //$this->loadModel($id)->delete();
                $model = $this->loadModel($id);
                $model->status = 3;
                $model->user_id = Yii::app()->user->id;
                $model->date_update = time();
                $model->date_admin = time();
                $model->update(array('status', 'user_id', 'date_update', 'date_admin'));
                
                if ( !isset($_GET['ajax']) )
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            //} else
            //    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	public function actionToBlackList($id)
        {
            $model = $this->loadModel($id);
            $model->status = 3;
            $model->user_id = Yii::app()->user->id;
            $model->date_update = time();
            $model->date_admin = time();
            $model->update(array('status', 'user_id', 'date_update', 'date_admin'));
            
            $blackList = new BlackList;
            $blackList->date = time();
            $blackList->user_id = Yii::app()->user->id;
            $blackList->phone = $model->phone;
            $blackList->save();
            
            if ( strlen($model->phone2)!=0 ) {
                $blackList = new BlackList;
                $blackList->date = time();
                $blackList->user_id = Yii::app()->user->id;
                $blackList->phone = $model->phone2;
                $blackList->save();
            }
            
            if ( strlen($model->phone)!=0 ) {
                Object::model()->updateAll(array(
                    'status'=>3,
                    'user_id'=>Yii::app()->user->id,
                    'date_update'=>time(),
                    'date_admin'=>time(),
                ), '(`phone`=\''.$model->phone.'\' OR `phone2`=\''.$model->phone.'\') AND (`status`=0 OR `status`=1)');
            }

            $this->redirect(array('index'));
        }
        public function actionToBlackList2($id)
        {
            $model = $this->loadModel($id);
            $model->status = 3;
            $model->user_id = Yii::app()->user->id;
            $model->date_update = time();
            $model->date_admin = time();
            $model->update(array('status', 'user_id', 'date_update', 'date_admin'));
            
            $blackList = new BlackList;
            $blackList->date = time();
            $blackList->user_id = Yii::app()->user->id;
            $blackList->phone = $model->phone;
            $blackList->save();
            
            if ( strlen($model->phone2)!=0 ) {
                $blackList = new BlackList;
                $blackList->date = time();
                $blackList->user_id = Yii::app()->user->id;
                $blackList->phone = $model->phone2;
                $blackList->save();
            }
            
            if ( strlen($model->phone)!=0 ) {
                Object::model()->updateAll(array(
                    'status'=>3,
                    'user_id'=>Yii::app()->user->id,
                    'date_update'=>time(),
                    'date_admin'=>time(),
                ), '(`phone`=\''.$model->phone.'\' OR `phone2`=\''.$model->phone.'\') AND (`status`=0 OR `status`=1)');
            }
        }

        
        public function action_ajax_info()
        {
            $model = Object::model()->findByPk($_POST['id']);
            echo json_encode(array(
                'desc'=>$model->desc,
                'daily'=>$model->daily,
            ));
        }
        
        
        public function action_ajax_status_update()
        {
            if ( $_POST['status']==1 ) {
                $model = $this->loadModel($_POST['object_id']);
                $model->status = 1;
                $model->user_id = Yii::app()->user->id;
                $model->date_update = time();
                $model->date_admin = time();
                if ( $_POST['free']==1 ) {
                    $model->free = 1;
                    $model->free_date = strtotime($_POST['free_date']);
                }
                if ( $_POST['show']==1 ) {
                    $model->show = 1;
                    $model->show_date = strtotime($_POST['show_date']);
                    $model->show_type = $_POST['show_type'];
                }
                if ( $_POST['daily']==1 ) {
                    $model->daily = 1;
                } else {
                    $model->daily = 0;
                }
                if ( $_POST['coop']==1 ) {
                    $model->coop = 1;
                } else {
                    $model->coop = 0;
                }
                $model->update(array('status', 'user_id', 'date_update', 'date_admin', 'free', 'free_date', 'show', 'show_date', 'show_type', 'daily', 'coop'));
            }
            if ( $_POST['status']==3 ) {
                $this->actionToBlackList2($_POST['object_id']);
            }
            if ( $_POST['status']==2 ) {
                $model = $this->loadModel($_POST['object_id']);
                $model->status = 2;
                $model->user_id = Yii::app()->user->id;
                $model->date_update = time();
                $model->date_admin = time();
                $model->update(array('status', 'user_id', 'date_update', 'date_admin'));
            }
            if ( $_POST['status']==4 ) {
                $model = $this->loadModel($_POST['object_id']);
                $model->status = 4;
                $model->user_id = Yii::app()->user->id;
                $model->date_update = time();
                $model->date_admin = time();
                $model->update(array('status', 'user_id', 'date_update', 'date_admin'));
            }
            
            echo $_POST['object_id'];
        }
        
}