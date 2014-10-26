<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        
        public function init()
        {           
            if ( isset($_GET['world']) ) {
                Yii::app()->request->cookies['world'] = new CHttpCookie('world', $_GET['world'], array('path'=>'/', 'expire'=>time()+3600*24*30));
            }
            $currentWorld = Yii::app()->request->cookies->contains('world') ? Yii::app()->request->cookies['world']->value : '';
            if ( strlen($currentWorld)==0 ) {
                $currentWorld = 'zz2';
                Yii::app()->request->cookies['world'] = new CHttpCookie('world', $currentWorld, array('path'=>'/', 'expire'=>time()+3600*24*30));
            }
            
            Yii::app()->request->cookies['world'] = new CHttpCookie('world', $currentWorld, array('path'=>'/', 'expire'=>time()+3600*24*30));
        }
        
        
        public function getConfig()
        {
            return Config::model()->findByPk(1);
        }
        
        
        public function getWorld()
        {
            return Yii::app()->request->cookies['world'];
        }
        
        
        public function getServers()
        {
            return array(
                
                array(
                    'url'=>'https://beta.tribalwars2.com',
                    'name'=>'Beta',
                    'worlds'=>array(
                        array(
                            'name'=>'zz2',
                            'fullName'=>'Expertus',
                        ),
                        array(
                            'name'=>'zz3',
                            'fullName'=>'Experior',
                        ),
                        array(
                            'name'=>'zz1',
                            'fullName'=>'Rudimentum',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://en.tribalwars2.com',
                    'name'=>'En',
                    'worlds'=>array(
                        array(
                            'name'=>'en1',
                            'fullName'=>'Alnwick',
                        ),
                        array(
                            'name'=>'en2',
                            'fullName'=>'Bastille',
                        ),
                        array(
                            'name'=>'en3',
                            'fullName'=>'Castel del Monte',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://de.tribalwars2.com',
                    'name'=>'De',
                    'worlds'=>array(
                        array(
                            'name'=>'de1',
                            'fullName'=>'Alnwick',
                        ),
                        array(
                            'name'=>'de2',
                            'fullName'=>'Bastille',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://nl.tribalwars2.com/',
                    'name'=>'Nl',
                    'worlds'=>array(
                        array(
                            'name'=>'nl1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://fr.tribalwars2.com/',
                    'name'=>'Fr',
                    'worlds'=>array(
                        array(
                            'name'=>'fr1',
                            'fullName'=>'Alnwick',
                        ),
                        array(
                            'name'=>'fr2',
                            'fullName'=>'Bastille',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://pl.tribalwars2.com/',
                    'name'=>'Pl',
                    'worlds'=>array(
                        array(
                            'name'=>'pl1',
                            'fullName'=>'Alnwick',
                        ),
                        array(
                            'name'=>'pl2',
                            'fullName'=>'Bastille',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://ru.tribalwars2.com/',
                    'name'=>'Ru',
                    'worlds'=>array(
                        array(
                            'name'=>'ru1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://br.tribalwars2.com/',
                    'name'=>'Br',
                    'worlds'=>array(
                        array(
                            'name'=>'br1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://us.tribalwars2.com/',
                    'name'=>'Us',
                    'worlds'=>array(
                        array(
                            'name'=>'us1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://es.tribalwars2.com/',
                    'name'=>'Es',
                    'worlds'=>array(
                        array(
                            'name'=>'es1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://it.tribalwars2.com/',
                    'name'=>'It',
                    'worlds'=>array(
                        array(
                            'name'=>'it1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://gr.tribalwars2.com/',
                    'name'=>'Gr',
                    'worlds'=>array(
                        array(
                            'name'=>'gr1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://cz.tribalwars2.com/',
                    'name'=>'Cz',
                    'worlds'=>array(
                        array(
                            'name'=>'cz1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://pt.tribalwars2.com/',
                    'name'=>'Pt',
                    'worlds'=>array(
                        array(
                            'name'=>'pt1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://se.tribalwars2.com/',
                    'name'=>'Se',
                    'worlds'=>array(
                        array(
                            'name'=>'se1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://no.tribalwars2.com/',
                    'name'=>'No',
                    'worlds'=>array(
                        array(
                            'name'=>'no1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://dk.tribalwars2.com/',
                    'name'=>'Dk',
                    'worlds'=>array(
                        array(
                            'name'=>'dk1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://fi.tribalwars2.com/',
                    'name'=>'Fi',
                    'worlds'=>array(
                        array(
                            'name'=>'fi1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://sk.tribalwars2.com/',
                    'name'=>'Sk',
                    'worlds'=>array(
                        array(
                            'name'=>'sk1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://ro.tribalwars2.com/',
                    'name'=>'Ro',
                    'worlds'=>array(
                        array(
                            'name'=>'ro1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://hu.tribalwars2.com/',
                    'name'=>'Hu',
                    'worlds'=>array(
                        array(
                            'name'=>'hu1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
                array(
                    'url'=>'https://ar.tribalwars2.com/',
                    'name'=>'Ar',
                    'worlds'=>array(
                        array(
                            'name'=>'ar1',
                            'fullName'=>'Alnwick',
                        ),
                    ),
                ),
                
            );
        }
        
        
        public function getWorlds()
        {
            $result = array();
            foreach ( $this->servers as $server ) {
                foreach ( $server['worlds'] as $w ) {
                    $result[] = $w['name'];
                }
            }
            return $result;
        }
        
        
        public function getWorldName()
        {
            $servers = $this->servers;
            $currentWorld = $this->world;
            foreach ( $servers as $server ) {
                $worlds = $server['worlds'];
                foreach ( $worlds as $world ) {
                    if ( $world['name']==$currentWorld ) {
                        return $server['name'] . ' - ' . $world['name'] . ' (' . $world['fullName'] . ')';
                    }
                }
            }
        }
        
        
        public function getWorldList()
        {
            $result = array();
            $servers = $this->servers;
            foreach ( $servers as $server ) {
                $worlds = $server['worlds'];
                foreach ( $worlds as $world ) {
                    $result[] = array(
                        'label'=>$server['name'] . ' - ' . $world['name'] . ' (' . $world['fullName'] . ')',
                        'url'=>'#'.$world['name'],
                    );
                }
            }
            return $result;
        }
}