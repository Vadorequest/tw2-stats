<?php

class ParserController extends AdminController
{
    public $header = 'Парсер';
    public function getMenu() 
    {
        return array();
    }
    
        
    public function init()
    {
        set_time_limit(0);
        mb_internal_encoding('UTF-8');
        error_reporting( E_ERROR );
    }
    
    
    public function compare($mask_real, $mask_test)
    {
        $count = 0;
        $uncount = 0;
        for ( $x=0;$x<6;$x++ ){
            for ( $y=0;$y<10;$y++ ){
                if ( $mask_real[$x][$y]==$mask_test[$x][$y] ) {
                    $count++;
                } else {
                    $uncount++;
                    if ( $uncount>12 ) { // 20%
                        break;
                        return 0;
                    }
                }
            }
        }
        return ($count/60)*100;
    }
    
    
    public function actionP()
    {
        echo CHtml::link('_p_irr', array('/admin/parser/_p_irr')).'<br />';
        echo CHtml::link('_p_avito', array('/admin/parser/_p_avito')).'<br />';
        echo CHtml::link('_p_client_avito', array('/admin/parser/_p_client_avito')).'<br />';
    }
    
    
    public function action_p_irr()
    {
        $urls = array(
            'квартира'=>'http://omsk.irr.ru/real-estate/rent/search/sort/date_sort:desc/page_len60/',
            'комната'=>'http://omsk.irr.ru/real-estate/rooms-rent/search/sort/date_sort:desc/page_len60/',
            'дом'=>'http://omsk.irr.ru/real-estate/out-of-town-rent/search/sort/date_sort:desc/page_len60/',
            'офис'=>'http://omsk.irr.ru/real-estate/commercial/offices/search/sort/date_sort:desc/page_len60/',
            'торговля и сервис'=>'http://omsk.irr.ru/real-estate/commercial/retail/search/sort/date_sort:desc/page_len60/',
            'производство и склады'=>'http://omsk.irr.ru/real-estate/commercial/production-warehouses/search/sort/date_sort:desc/page_len60/',
            'здания и особняки'=>'http://omsk.irr.ru/real-estate/commercial/houses/search/sort/date_sort:desc/page_len60/',
            'кафе. бары. рестораны'=>'http://omsk.irr.ru/real-estate/commercial/eating/search/sort/date_sort:desc/page_len60/',
            'другого и свободного назначения'=>'http://omsk.irr.ru/real-estate/commercial/misc/search/sort/date_sort:desc/page_len60/',
        );
        
        include 'phpQuery.php';
        
        $board = Board::model()->findByPk('1');
        $date_last_board = ($board->date_last_board!=null)?$board->date_last_board:(time()-3600*24*7);
        
        foreach ( $urls as $k => $u ) {
            
            $obj_date = time();
            $current_page = 1;
            $advs = array();
            while ( $obj_date>$date_last_board ) {
                $url = $urls[$k].'page'.$current_page++.'/';
                $page = phpQuery::newDocumentHTML(file_get_contents($url));
                $max_count = preg_replace('/\D/', '', $page->find('#finded_ads')->text());
                $max_page = ceil($max_count/60);
                $objs = $page->find('.add_list');
                foreach ( $objs as $obj ) {
                    $current_count++;
                    $obj = pq($obj);
                    $obj_date = strtotime($obj->find('.adv_data')->text());
                    if ( $obj_date>$date_last_board && stripos($obj->find('.add_title')->attr('href'), 'omsk.irr.ru')!==false ) {
                        $advs[] = array(
                            'date' => date('d.m.Y h:i', $obj_date),
                            'link' => $obj->find('.add_title')->attr('href'),
                        );
                    }
                }
                if ( $current_page>=$max_page ) {
                    break;
                }
            }

            $data = array();
            foreach ( $advs as $_key => $adv ) {
                $page = phpQuery::newDocumentHTML(file_get_contents($adv['link']));

                $type_id = '';
                switch ( $k ) {
                    case 'квартира':
                        break;
                    case 'комната':
                        $type_id = 5;
                        break;
                    case 'дом':
                        $type_id = 8;
                        break;
                    case 'офис':
                        $type_id = 11;
                        break;
                    case 'торговля и сервис':
                        $type_id = 12;
                        break;
                    case 'производство и склады':
                        $type_id = 13;
                        break;
                    case 'здания и особняки':
                        $type_id = 14;
                        break;
                    case 'кафе. бары. рестораны':
                        $type_id = 15;
                        break;
                    case 'другого и свободного назначения':
                        $type_id = 16;
                        break;
                }
                
                $data[$_key] = array(
                    'url'=>$adv['link'],
                    'name'=>'',
                    'desc'=>'',
                    'street'=>'',
                    'house'=>'',
                    'type_id'=>$type_id,
                    'area_id'=>'',
                    'daily'=>'',
                    'price'=>'',
                    'furniture'=>'',
                    'phone'=>'',
                    'phone2'=>'',
                    'repair'=>'',
                    'imgs'=>array(),
                );
                
                $imgs = $page->find('#slider_pagination li img');
                if ( count($imgs)!=0 ) {
                    foreach ( $imgs as $img ) {
                        $src = pq($img)->attr('src');
                        $src = str_replace('small', 'orig', $src);
                        $data[$_key]['imgs'][] = $src;
                    }
                }

                $info_blocks = $page->find('.form_info p');
                foreach ( $info_blocks as $info_block ) {
                    if ( in_array(pq($info_block)->text(), array('Контактное лицо:', 'Продавец:')) ) {
                        if ( strripos(pq($info_block)->next()->text(), '—')!==false ) {
                            preg_match('/(\w*)/uis', str_replace("\n", "", trim(pq($info_block)->next()->text())), $_name);
                            $data[$_key]['name'] = $_name[0];
                        } else {
                            $data[$_key]['name'] = mb_convert_case(trim(pq($info_block)->next()->text()), 2, 'UTF-8');
                        }
                    }
                    if ( pq($info_block)->text()=='Комнат в квартире:' ) {
                        $rooms = trim(pq($info_block)->next()->text());
                        if ( $rooms=='1' ) {
                            $data[$_key]['type_id'] = 1;
                        } elseif ( $rooms=='2' ) {
                            $data[$_key]['type_id'] = 2;
                        } else {
                            $data[$_key]['type_id'] = 3;
                        }
                    }
                    if ( pq($info_block)->text()=='АО:' ) {
                        $area = pq($info_block)->next()->text();
                        if ( strripos($area, 'Кировский')!==false ) {
                            $data[$_key]['area_id'] = 2;
                        } elseif ( strripos($area, 'Ленинский')!==false ) {
                            $data[$_key]['area_id'] = 3;
                        } elseif ( strripos($area, 'Октябрьский')!==false ) {
                            $data[$_key]['area_id'] = 4;
                        } elseif ( strripos($area, 'Советский')!==false ) {
                            $data[$_key]['area_id'] = 5;
                        } elseif ( strripos($area, 'Центральный')!==false ) {
                            $data[$_key]['area_id'] = 6;
                        }
                    }
                    if ( pq($info_block)->text()=='Период аренды:' ) {
                        $daily = trim(pq($info_block)->next()->text());
                        if ( $daily=='Долгосрочная' ) {
                            $data[$_key]['daily'] = 0;
                        } else {
                            $data[$_key]['daily'] = 1;
                        }
                    }
                    if ( pq($info_block)->text()=='Ремонт:' ) {
                        if ( trim(pq($info_block)->next()->text())=='евроремонт' ) {
                            $data[$_key]['repair'] = 1;
                        }
                        if ( trim(pq($info_block)->next()->text())=='типовой' ) {
                            $data[$_key]['repair'] = 0;
                        }
                    }
                    if ( pq($info_block)->text()=='Мебель:' ) {
                        if ( pq($info_block)->next()->find('.icheckbox.checked') ) {
                            $data[$_key]['furniture'] = 1;
                        } else {
                            $data[$_key]['furniture'] = 0;
                        }

                    }
                }

                $desc = $page->find('span.title');
                foreach ($desc as $desc_in) {
                    if ( pq($desc_in)->text()=='Описание товара' ) {
                        $data[$_key]['desc'] = pq($desc_in)->next()->text();
                    }
                    if ( pq($desc_in)->text()=='Расположение' ) {
                        $address = pq($desc_in)->next()->text();
                        preg_match('/Омск\, (.*)\, (.*)/uis', $address, $address_inner);
                        if ( count($address_inner)!=0 ) {
                            $data[$_key]['street'] = $address_inner[1];
                            $data[$_key]['house'] = $address_inner[2];
                        } else {
                            preg_match('/Омск\, (.*)/uis', $address, $address_inner);
                            $data[$_key]['street'] = $address_inner[1];
                        }

                    }
                }

                $data[$_key]['price'] = preg_replace('/\D/', '', $page->find('.credit_cost li:first')->text());
                if ( strlen($data[$_key]['furniture'])==0 ) {
                    if ( strripos($desc, 'мебель')!==false ) {
                        $data[$_key]['furniture'] = 1;
                    }
                }
                if ( strlen($data[$_key]['repair'])==0 ) {
                    if ( strripos($desc, 'евроремонт')!==false ) {
                        $data[$_key]['repair'] = 1;
                    }
                }
                if ( strlen($data[$_key]['name'])==0 || $data[$_key]['name']=='Частное' ) {
                    if ( strlen(trim(strip_tags(base64_decode($page->find('#allphones')->attr('value')))))>1 ) {
                        $data[$_key]['name'] = trim(strip_tags(base64_decode($page->find('#allphones')->attr('value'))));
                    }
                }

                preg_match_all("/(http:\\/\\/)?([a-z_0-9-.]+\\.[a-z]{2,3}(([ \"'>\r\n\t])|(\\/([^ \"'>\r\n\t]*)?)))/uis", base64_decode($page->find('#allphones')->attr('value')), $phones);
                for ( $a=0; $a<2; $a++ ) {
                    if ( strlen($phones[0][$a])!=0 ) {
                        $img = imagecreatefromjpeg($phones[0][$a]);
                        $width = imagesx($img);
                        $height = imagesy($img);

                        for ( $x=0;$x<$width;$x++ ) {
                            for ( $y=0;$y<$height;$y++ ) {
                                $rgb = imagecolorat($img, $x, $y);
                                $r = ($rgb >> 16) & 0xFF;
                                $g = ($rgb >> 8) & 0xFF;
                                $b = $rgb & 0xFF;
                                $z = 0.299*$r+0.587*$g+0.114*$b;
                                if ( $z>155 ) {
                                    imagesetpixel($img, $x, $y, 0xFFFFFF);
                                } else {
                                    imagesetpixel($img, $x, $y, 0x000000);
                                }
                            }
                        }

                        $img2 = imagecreatetruecolor($width-/*10*/8, $height-5);
                        imagecopyresized($img2, $img, 0, 0, 1, 3, $width, $height, $width, $height);

                        $count = floor((imagesx($img2)+2)/8);

                        $mask_test = array();
                        $masks = array(
                            '0'=>array(array(0,1,1,1,1,1,1,1,1,0),array(1,1,0,0,0,0,0,0,1,1),array(1,0,0,0,0,0,0,0,0,1),array(1,0,0,0,0,0,0,0,0,1),array(1,1,0,0,0,0,0,0,1,1),array(0,1,1,1,1,1,1,1,1,0)),
                            '1'=>array(array(0,0,0,0,0,0,0,0,0,0),array(0,1,0,0,0,0,0,0,0,0),array(0,1,0,0,0,0,0,0,0,0),array(1,1,1,1,1,1,1,1,1,1),array(0,0,0,0,0,0,0,0,0,0),array(0,0,0,0,0,0,0,0,0,0)),
                            '2'=>array(array(0,1,0,0,0,0,0,0,1,1),array(1,0,0,0,0,0,0,1,0,1),array(1,0,0,0,0,0,1,0,0,1),array(1,0,0,0,0,1,1,0,0,1),array(1,1,0,0,1,1,0,0,0,1),array(0,0,1,1,0,0,0,0,0,1)),
                            '3'=>array(array(0,1,0,0,0,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,1,0,1,0,1,0,0,1,1),array(0,1,1,0,0,1,1,1,1,0)),
                            '4'=>array(array(0,0,0,0,0,1,1,1,0,0),array(0,0,0,0,1,0,0,1,0,0),array(0,0,1,1,0,0,0,1,0,0),array(0,1,0,0,0,0,0,1,0,0),array(1,1,1,1,1,1,1,1,1,1),array(0,0,0,0,0,0,0,1,0,0)),
                            '5'=>array(array(0,1,1,1,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,1,0,0,1,1),array(0,0,0,0,0,1,1,1,1,0)),
                            '6'=>array(array(0,0,1,1,1,1,1,1,0,0),array(0,1,1,0,0,1,0,0,1,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,0,1,1,1,1,0)),
                            '7'=>array(array(1,0,0,0,0,0,0,0,0,0),array(1,0,0,0,0,0,0,0,0,1),array(1,0,0,0,0,0,0,1,1,0),array(1,0,0,0,0,1,1,0,0,0),array(1,0,1,1,1,0,0,0,0,0),array(1,1,0,0,0,0,0,0,0,0)),
                            '8'=>array(array(0,1,1,0,0,0,1,1,1,0),array(1,0,0,1,1,1,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,1,0,1,0,0,0,1),array(0,1,1,0,0,1,1,1,1,0)),
                            '9'=>array(array(0,1,1,1,1,0,0,0,0,1),array(1,1,0,0,0,1,0,0,0,1),array(1,0,0,0,0,1,0,0,0,1),array(1,0,0,0,0,1,0,0,0,1),array(1,1,0,0,1,0,0,1,1,0),array(0,1,1,1,1,1,1,1,0,0)),
                            '+'=>array(array(0,0,0,0,0,1,0,0,0,0),array(0,0,0,0,0,1,0,0,0,0),array(0,0,0,0,0,1,0,0,0,0),array(0,0,0,0,0,1,0,0,0,0),array(0,0,0,0,0,1,0,0,0,0),array(0,0,0,0,0,1,0,0,0,0)),
                        );

                        for ( $i=0; $i<$count; $i++ ) {
                            for ( $x=$i*8; $x<$i*8+6; $x++ ) {
                                for ( $y=0; $y<10; $y++ ) {
                                    $index = imagecolorat($img2, $x, $y);
                                    $mask_test[$i][$x%8][$y] = ($index==0xffffff)?0:1;
                                }
                            }
                        }
                        
                        $result = array();
                        $percent = array();
                        $c = array();
                        $r = '';
                        for ( $i=0; $i<$count; $i++ ) {
                            foreach ( $masks as $key => $mask ) {
                                $percent[$i] = $this->compare($mask, $mask_test[$i]);
                                if ( $percent[$i]>$c[$i] ) {
                                    $c[$i] = $percent[$i];
                                    $result[$i] = $key;
                                }
                            }
                            $r .= $result[$i];
                        }                    
                        $_text_phone = ($a==0)?'phone':'phone2';
                        if ( strlen($r)==6 ) {
                            $data[$_key][$_text_phone] = '3812'.$r;
                        } elseif ( substr($r, 0, 2)=='+7' ) {
                            $data[$_key][$_text_phone] = substr($r, 2);
                        } elseif ( substr($r, 0, 1)=='8' && strlen($r)==11 ) {
                            $data[$_key][$_text_phone] = substr($r, 1);
                        } else {
                            $data[$_key][$_text_phone] = $r;
                        }
                    }
                }
            }

            $count_black = 0;
            $not_address = 0;
            $not_type = 0;
            $not_phone = 0;
            $count_total = 0;

            foreach ( $data as $d ) {
                if ( !BlackList::model()->find('`phone`=\''.$d['phone'].'\' OR `phone`=\''.$d['phone2'].'\'') ) {
                    $newObject = new Object;
                    $newObject->date_create = time();
                    $newObject->board_id = 1;
                    $newObject->url = $d['url'];
                    $newObject->name = $d['name'];
                    $newObject->desc = htmlspecialchars($d['desc']);
                    $newObject->street = $d['street'];
                    if ( strlen($d['street'])==0 ) {
                        $not_address++;
                    }
                    $newObject->house = $d['house'];
                    $newObject->type_id = $d['type_id'];
                    if ( strlen($d['type_id'])==0 ) {
                        $not_type++;
                    }
                    $newObject->area_id = $d['area_id'];
                    $newObject->daily = $d['daily'];
                    $newObject->price = $d['price'];
                    $newObject->furniture = $d['furniture'];
                    if ( strlen($d['phone'])==10 ) {
                        $newObject->phone = $d['phone'];
                    } 
                    if ( strlen($d['phone2'])==10 ) {
                        $newObject->phone2 = $d['phone2'];
                    }
                    if ( strlen($d['phone'])!=10 && strlen($d['phone2'])!=10 ) {
                        $not_phone++;
                    }
                    $newObject->repair = $d['repair'];
                    $newObject->origin = 2;
                    if ( $newObject->save() ) {
                        $count_total++;
                        
                        if ( count($d['imgs'])!=0 ) {
                            foreach ( $d['imgs'] as $src ) {
                                $imageName = substr(md5($src.microtime()), 0, 28).'.jpg';
                                $temp = md5($src).'.jpg';
                                copy($src, './uploads/temp/'.$temp);
                                $image = Yii::app()->image->load('./uploads/temp/'.$temp);
                                $image->save('./uploads/object/'.$imageName);
                                $image->resize(256, 256);
                                $image->save('./uploads/object/preview/'.$imageName);
                                $objectImage = new ObjectImage;
                                $objectImage->object_id = $newObject->id;
                                $objectImage->img = $imageName;
                                $objectImage->save();
                            }
                        }
                        
                    }
                } else {
                    $count_black++;
                } 
            }

            if ( $count_total!=0 || $count_black!=0 ) {
                $parserStatistic = new ParserStatistic;
                $parserStatistic->date = time();
                $parserStatistic->board_id = 1;
                $parserStatistic->count_total = $count_total;
                $parserStatistic->count_black = $count_black;
                $parserStatistic->not_address = $not_address;
                $parserStatistic->not_type = $not_type;
                $parserStatistic->not_phone = $not_phone;
                $parserStatistic->save();
            }
            
        }

        ////////////////////////////////////////////////////////////////////////
        
        $board->date_last_board = time();
        $board->update(array('date_last_board'));
    }
    
    
    public function actionTest()
    {
        /**/
        $advs = array(array('link'=>'http://omsk.irr.ru/real-estate/rooms-rent/1-komn-v-2-komnatnoy-kv-Omsk-Himikov-ul-6-etazh-5-advert296961510.html'));
        /**/
        $data = array();
        foreach ( $advs as $_key => $adv ) {
            $page = phpQuery::newDocumentHTML(file_get_contents($adv['link']));

            $type_id = '';
            switch ( $k ) {
                case 'квартира':
                    break;
                case 'комната':
                    $type_id = 5;
                    break;
                case 'дом':
                    $type_id = 8;
                    break;
                case 'офис':
                    $type_id = 11;
                    break;
                case 'торговля и сервис':
                    $type_id = 12;
                    break;
                case 'производство и склады':
                    $type_id = 13;
                    break;
                case 'здания и особняки':
                    $type_id = 14;
                    break;
                case 'кафе. бары. рестораны':
                    $type_id = 15;
                    break;
                case 'другого и свободного назначения':
                    $type_id = 16;
                    break;
            }

            $data[$_key] = array(
                'url'=>$adv['link'],
                'name'=>'',
                'desc'=>'',
                'street'=>'',
                'house'=>'',
                'type_id'=>$type_id,
                'area_id'=>'',
                'daily'=>'',
                'price'=>'',
                'furniture'=>'',
                'phone'=>'',
                'phone2'=>'',
                'repair'=>'',
            );

            $info_blocks = $page->find('.form_info p');
            foreach ( $info_blocks as $info_block ) {
                if ( in_array(pq($info_block)->text(), array('Контактное лицо:', 'Продавец:')) ) {
                    if ( strripos(pq($info_block)->next()->text(), '—')!==false ) {
                        preg_match('/(\w*)/uis', str_replace("\n", "", trim(pq($info_block)->next()->text())), $_name);
                        $data[$_key]['name'] = $_name[0];
                    } else {
                        $data[$_key]['name'] = mb_convert_case(trim(pq($info_block)->next()->text()), 2, 'UTF-8');
                    }
                    if ( $data[$_key]['name']=='Не' ) {
                        $data[$_key]['name'] = 'Не агенство';
                    }
                }
                if ( pq($info_block)->text()=='Комнат в квартире:' ) {
                    $rooms = trim(pq($info_block)->next()->text());
                    if ( $rooms=='1' ) {
                        $data[$_key]['type_id'] = 1;
                    } elseif ( $rooms=='2' ) {
                        $data[$_key]['type_id'] = 2;
                    } else {
                        $data[$_key]['type_id'] = 3;
                    }
                }
                if ( pq($info_block)->text()=='АО:' ) {
                    $area = pq($info_block)->next()->text();
                    if ( strripos($area, 'Кировский')!==false ) {
                        $data[$_key]['area_id'] = 2;
                    } elseif ( strripos($area, 'Ленинский')!==false ) {
                        $data[$_key]['area_id'] = 3;
                    } elseif ( strripos($area, 'Октябрьский')!==false ) {
                        $data[$_key]['area_id'] = 4;
                    } elseif ( strripos($area, 'Советский')!==false ) {
                        $data[$_key]['area_id'] = 5;
                    } elseif ( strripos($area, 'Центральный')!==false ) {
                        $data[$_key]['area_id'] = 6;
                    }
                }
                if ( pq($info_block)->text()=='Период аренды:' ) {
                    $daily = trim(pq($info_block)->next()->text());
                    if ( $daily=='Долгосрочная' ) {
                        $data[$_key]['daily'] = 0;
                    } else {
                        $data[$_key]['daily'] = 1;
                    }
                }
                if ( pq($info_block)->text()=='Ремонт:' ) {
                    if ( trim(pq($info_block)->next()->text())=='евроремонт' ) {
                        $data[$_key]['repair'] = 1;
                    }
                    if ( trim(pq($info_block)->next()->text())=='типовой' ) {
                        $data[$_key]['repair'] = 0;
                    }
                }
                if ( pq($info_block)->text()=='Мебель:' ) {
                    if ( pq($info_block)->next()->find('.icheckbox.checked') ) {
                        $data[$_key]['furniture'] = 1;
                    } else {
                        $data[$_key]['furniture'] = 0;
                    }

                }
            }

            $desc = $page->find('span.title');
            foreach ($desc as $desc_in) {
                if ( pq($desc_in)->text()=='Описание товара' ) {
                    $data[$_key]['desc'] = pq($desc_in)->next()->text();
                }
                if ( pq($desc_in)->text()=='Расположение' ) {
                    $address = pq($desc_in)->next()->text();
                    preg_match('/Омск\, (.*)\, (.*)/uis', $address, $address_inner);
                    if ( count($address_inner)!=0 ) {
                        $data[$_key]['street'] = $address_inner[1];
                        $data[$_key]['house'] = $address_inner[2];
                    } else {
                        preg_match('/Омск\, (.*)/uis', $address, $address_inner);
                        $data[$_key]['street'] = $address_inner[1];
                    }

                }
            }

            $data[$_key]['price'] = preg_replace('/\D/', '', $page->find('.credit_cost li:first')->text());
            if ( strlen($data[$_key]['furniture'])==0 ) {
                if ( strripos($desc, 'мебель')!==false ) {
                    $data[$_key]['furniture'] = 1;
                }
            }
            if ( strlen($data[$_key]['repair'])==0 ) {
                if ( strripos($desc, 'евроремонт')!==false ) {
                    $data[$_key]['repair'] = 1;
                }
            }
            if ( strlen($data[$_key]['name'])==0 || $data[$_key]['name']=='Частное' ) {
                if ( strlen(trim(strip_tags(base64_decode($page->find('#allphones')->attr('value')))))>1 ) {
                    $data[$_key]['name'] = trim(strip_tags(base64_decode($page->find('#allphones')->attr('value'))));
                }
            }

            preg_match_all("/(http:\\/\\/)?([a-z_0-9-.]+\\.[a-z]{2,3}(([ \"'>\r\n\t])|(\\/([^ \"'>\r\n\t]*)?)))/uis", base64_decode($page->find('#allphones')->attr('value')), $phones);
            for ( $a=0; $a<2; $a++ ) {
                if ( strlen($phones[0][$a])!=0 ) {
                    $img = imagecreatefromjpeg($phones[0][$a]);
                    $width = imagesx($img);
                    $height = imagesy($img);

                    for ( $x=0;$x<$width;$x++ ) {
                        for ( $y=0;$y<$height;$y++ ) {
                            $rgb = imagecolorat($img, $x, $y);
                            $r = ($rgb >> 16) & 0xFF;
                            $g = ($rgb >> 8) & 0xFF;
                            $b = $rgb & 0xFF;
                            $z = 0.299*$r+0.587*$g+0.114*$b;
                            if ( $z>155 ) {
                                imagesetpixel($img, $x, $y, 0xFFFFFF);
                            } else {
                                imagesetpixel($img, $x, $y, 0x000000);
                            }
                        }
                    }

                    $img2 = imagecreatetruecolor($width-/*10*/8, $height-5);
                    imagecopyresized($img2, $img, 0, 0, 1, 3, $width, $height, $width, $height);

                    $count = floor((imagesx($img2)+2)/8);

                    $mask_test = array();
                    $masks = array(
                        '0'=>array(array(0,1,1,1,1,1,1,1,1,0),array(1,1,0,0,0,0,0,0,1,1),array(1,0,0,0,0,0,0,0,0,1),array(1,0,0,0,0,0,0,0,0,1),array(1,1,0,0,0,0,0,0,1,1),array(0,1,1,1,1,1,1,1,1,0)),
                        '1'=>array(array(0,0,0,0,0,0,0,0,0,0),array(0,1,0,0,0,0,0,0,0,0),array(0,1,0,0,0,0,0,0,0,0),array(1,1,1,1,1,1,1,1,1,1),array(0,0,0,0,0,0,0,0,0,0),array(0,0,0,0,0,0,0,0,0,0)),
                        '2'=>array(array(0,1,0,0,0,0,0,0,1,1),array(1,0,0,0,0,0,0,1,0,1),array(1,0,0,0,0,0,1,0,0,1),array(1,0,0,0,0,1,1,0,0,1),array(1,1,0,0,1,1,0,0,0,1),array(0,0,1,1,0,0,0,0,0,1)),
                        '3'=>array(array(0,1,0,0,0,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,1,0,1,0,1,0,0,1,1),array(0,1,1,0,0,1,1,1,1,0)),
                        '4'=>array(array(0,0,0,0,0,1,1,1,0,0),array(0,0,0,0,1,0,0,1,0,0),array(0,0,1,1,0,0,0,1,0,0),array(0,1,0,0,0,0,0,1,0,0),array(1,1,1,1,1,1,1,1,1,1),array(0,0,0,0,0,0,0,1,0,0)),
                        '5'=>array(array(0,1,1,1,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,1,0,0,1,1),array(0,0,0,0,0,1,1,1,1,0)),
                        '6'=>array(array(0,0,1,1,1,1,1,1,0,0),array(0,1,1,0,0,1,0,0,1,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,0,1,1,1,1,0)),
                        '7'=>array(array(1,0,0,0,0,0,0,0,0,0),array(1,0,0,0,0,0,0,0,0,1),array(1,0,0,0,0,0,0,1,1,0),array(1,0,0,0,0,1,1,0,0,0),array(1,0,1,1,1,0,0,0,0,0),array(1,1,0,0,0,0,0,0,0,0)),
                        '8'=>array(array(0,1,1,0,0,0,1,1,1,0),array(1,0,0,1,1,1,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,0,1,0,0,0,0,1),array(1,0,0,1,0,1,0,0,0,1),array(0,1,1,0,0,1,1,1,1,0)),
                        '9'=>array(array(0,1,1,1,1,0,0,0,0,1),array(1,1,0,0,0,1,0,0,0,1),array(1,0,0,0,0,1,0,0,0,1),array(1,0,0,0,0,1,0,0,0,1),array(1,1,0,0,1,0,0,1,1,0),array(0,1,1,1,1,1,1,1,0,0)),
                        '+'=>array(array(0,0,0,0,0,1,0,0,0,0),array(0,0,0,0,0,1,0,0,0,0),array(0,0,0,0,0,1,0,0,0,0),array(0,0,0,0,0,1,0,0,0,0),array(0,0,0,0,0,1,0,0,0,0),array(0,0,0,0,0,1,0,0,0,0)),
                    );

                    for ( $i=0; $i<$count; $i++ ) {
                        for ( $x=$i*8; $x<$i*8+6; $x++ ) {
                            for ( $y=0; $y<10; $y++ ) {
                                $index = imagecolorat($img2, $x, $y);
                                $mask_test[$i][$x%8][$y] = ($index==0xffffff)?0:1;
                            }
                        }
                    }

                    $result = array();
                    $percent = array();
                    $c = array();
                    $r = '';
                    for ( $i=0; $i<$count; $i++ ) {
                        foreach ( $masks as $key => $mask ) {
                            $percent[$i] = $this->compare($mask, $mask_test[$i]);
                            if ( $percent[$i]>$c[$i] ) {
                                $c[$i] = $percent[$i];
                                $result[$i] = $key;
                            }
                        }
                        $r .= $result[$i];
                    }                    
                    $_text_phone = ($a==0)?'phone':'phone2';
                    if ( strlen($r)==6 ) {
                        $data[$_key][$_text_phone] = '3812'.$r;
                    } elseif ( substr($r, 0, 2)=='+7' ) {
                        $data[$_key][$_text_phone] = substr($r, 2);
                    } elseif ( substr($r, 0, 1)=='8' && strlen($r)==11 ) {
                        $data[$_key][$_text_phone] = substr($r, 1);
                    } else {
                        $data[$_key][$_text_phone] = $r;
                    }
                    /**/
                    /*if ( $a==0 ) {
                        imagepng($img2, './uploads/temp.png');
                        echo '<img src="/uploads/temp.png" /><br />'.$r;
                        $result = 'array(';
                        for ( $x=0;$x<6;$x++ ) {
                            $result .= 'array(';
                            for ( $y=0;$y<10;$y++ ) {
                                $result .= $mask_test[1][$x][$y].',';
                            }
                            $result .= '),';
                        }
                        $result .= ')';
                        echo $result;
                    }*/
                    /**/
                }
            }
        }
        /**/
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        /**/
    }
    
    
    /*public function actionTest3()
    {
        include 'phpQuery.php';
        $objects = Object::model()->findAll('`board_id`=1');
        foreach ( $objects as $object ) {
            
            if ( count($object->objectImage)==0 ) {
                $url = $object->url;

                $page = phpQuery::newDocumentHTML(file_get_contents($url));
                $imgs = $page->find('#slider_pagination li img');
                if ( count($imgs)!=0 ) {
                    foreach ( $imgs as $img ) {
                        $src = pq($img)->attr('src');
                        $src = str_replace('small', 'orig', $src);
                        $imageName      = substr(md5($src.microtime()), 0, 28).'.jpg';
                        $temp = md5($src).'.jpg';
                        copy($src, './uploads/temp/'.$temp);
                        $image = Yii::app()->image->load('./uploads/temp/'.$temp);
                        $image->save('./uploads/object/'.$imageName);
                        $image->resize(256, 256);
                        $image->save('./uploads/object/preview/'.$imageName);
                        $objectImage = new ObjectImage;
                        $objectImage->object_id = $object->id;
                        $objectImage->img = $imageName;
                        $objectImage->save();
                    }
                }
            }
            
        }
    }*/
    
    
    public function avito_date($date)
    {
        $yesterday = false;
        $date = str_replace(array(
            'Размещено ',
            ' в',
        ), array(
            '',
            ',',
        ), $date);
        if ( strripos($date, 'Вчера')!==false || strripos($date, 'вчера')!==false ) {
            $yesterday = true;
            $date = str_replace(array(
                'Вчера',
                'вчера',
            ), array(
                'yesterday',
                'yesterday',
            ), $date);
        } elseif ( strripos($date, 'Сегодня')!==false || strripos($date, 'сегодня')!==false ) {
            $date = str_replace(array(
                'Сегодня',
                'сегодня',
            ), array(
                'today',
                'today',
            ), $date);
        } else {
            $date = str_replace(array(
                'января',
                'февраля',
                'марта',
                'апреля',
                'мая',
                'июня',
                'июля',
                'августа',
                'сентября',
                'октября',
                'ноября',
                'декабря',
            ), array(
                'january',
                'february',
                'march',
                'april',
                'may',
                'june',
                'july',
                'august',
                'september',
                'october',
                'november',
                'december',
            ), $date);
        }

        if ( $yesterday && date('G', strtotime(preg_replace('!\s++!u', ' ', $date)))<=4 ) {
            $date = strtotime(preg_replace('!\s++!u', ' ', $date))+3600*24;
        } else {
            $date = strtotime(preg_replace('!\s++!u', ' ', $date));
        }
        
        return $date;
    }
    

    public function action_p_avito()
    {
        $url = 'https://m.avito.ru/omsk/kvartiry/sdam?user=1';
        
        include 'phpQuery.php';
        
        $board = Board::model()->findByPk('2');
        $date_last_board = ($board->date_last_board!=null)?$board->date_last_board:(time()-3600*24*1);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);

        $page = phpQuery::newDocumentHTML($result);
        $article = $page->find('article:eq(2)');

        $first_adv_date = $this->avito_date(trim(pq($article)->find('.info-date')->text()));
        $first_adv_link = 'https://m.avito.ru'.pq($article)->find('a')->attr('href');
        
        $current_date = $first_adv_date;
        $current_url = $first_adv_link;
        $prev_url = $url;
        
        $data = array();
        $_key = -1;
        
        while ( $current_date>$date_last_board ) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_URL, $current_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_REFERER, $prev_url);
            $result = curl_exec($ch);
            preg_match_all('/^Location:(.*)$/mi', $result, $matches);
            curl_close($ch);
            
            if ( strlen($matches[1][0])!=0 ) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_URL, 'https://m.avito.ru'.trim($matches[1][0]));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_REFERER, $prev_url);
                $result = curl_exec($ch);
                //preg_match_all('/^Location:(.*)$/mi', $result, $matches);
                curl_close($ch);
            }
            
            //echo htmlspecialchars($result).'<hr />';
            
            $page = phpQuery::newDocumentHTML($result);
            
            $_key++;
            $data[$_key] = array(
                'url'=>$current_url,
                'name'=>'',
                'desc'=>'',
                'street'=>'',
                //'house'=>'',
                'type_id'=>'',
                'area_id'=>'',
                'daily'=>'',
                'price'=>'',
                'furniture'=>'',
                'phone'=>'',
                'repair'=>'',
                'imgs'=>array(),
                
                'date'=>'',
            );
            
            if ( strlen(trim($page->find('.person-name')->text()))!=0 ) {
                $data[$_key]['name'] = trim($page->find('.person-name')->text());
            } 
            if ( strlen(trim($page->find('.description-wrapper')->text()))!=0 ) {
                $data[$_key]['desc'] = trim($page->find('.description-wrapper')->text());
            }
            $fullAddress = trim($page->find('.address-person-params')->text());
            if ( strripos($fullAddress, 'Кировский')!==false ) {
                $data[$_key]['area_id'] = 2;
            } elseif ( strripos($fullAddress, 'Ленинский')!==false ) {
                $data[$_key]['area_id'] = 3;
            } elseif ( strripos($fullAddress, 'Октябрьский')!==false ) {
                $data[$_key]['area_id'] = 4;
            } elseif ( strripos($fullAddress, 'Советский')!==false ) {
                $data[$_key]['area_id'] = 5;
            } elseif ( strripos($fullAddress, 'Центральный')!==false ) {
                $data[$_key]['area_id'] = 6;
            }
            
            if ( strlen(trim($page->find('.text-user-address')->text()))!=0 ) {
                $data[$_key]['street'] = trim($page->find('.text-user-address')->text());
            }
            
            $mainDesc = trim($page->find('.single-item-header')->text());
            if ( strripos($mainDesc, '1-к квартира')!==false ) {
                $data[$_key]['type_id'] = 1;
            } elseif ( strripos($mainDesc, '2-к квартира')!==false ) {
                $data[$_key]['type_id'] = 2;
            } else {
                $data[$_key]['type_id'] = 3;
            }
            
            if ( strripos($mainDesc, 'посуточно')!==false ) {
                $data[$_key]['daily'] = 1;
            } else {
                $data[$_key]['daily'] = 0;
            }
            
            if ( strripos($data[$_key]['desc'], 'мебель')!==false ) {
                $data[$_key]['furniture'] = 1;
            }
            if ( strripos($data[$_key]['desc'], 'евроремонт')!==false ) {
                $data[$_key]['repair'] = 1;
            } elseif ( strripos($data[$_key]['desc'], 'ремонт')!==false ) {
                $data[$_key]['repair'] = 0;
            }
            
            $data[$_key]['price'] = preg_replace('/\D/', '', trim($page->find('.price-value')->text()));
            
            $phoneLink = $page->find('.action-show-number a')->attr('href');
            if ( strlen($phoneLink)!=0 ) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
                curl_setopt($ch, CURLOPT_URL, 'https://m.avito.ru'.$phoneLink.'?async');
                curl_setopt($ch, CURLOPT_REFERER, (strlen($matches[1][0])!=0)?$matches[1][0]:$data[$_key]['url']);
                //echo ((strlen($matches[1][0])!=0)?$matches[1][0]:$data[$_key]['url']).'<br />';
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                
                $data[$_key]['phone'] = preg_replace('/\D/', '', curl_exec($ch));
                $data[$_key]['phone'] = substr($data[$_key]['phone'], 1);
                curl_close($ch);
            }
            
            $imgs = $page->find('.photo-self');
            if ( count($imgs)!=0 ) {
                foreach ( $imgs as $img ) {
                    $src = pq($img)->attr('src');
                    $data[$_key]['imgs'][] = 'http://'.substr($src, 2);
                }
            }
        
            $current_date = $this->avito_date($page->find('.item-add-date')->text());
            $prev_url = $current_url;
            $current_url = 'https://m.avito.ru'.$page->find('.page-next a')->attr('href');
            $data[$_key]['date'] = $page->find('.item-add-date')->text().'|'.($current_date-$date_last_board);

            sleep(10);
        }
        
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        
        if ( 1 ) {
            $count_black = 0;
            $not_address = 0;
            $not_type = 0;
            $not_phone = 0;
            $count_total = 0;

            foreach ( $data as $d ) {
                if ( !BlackList::model()->find('`phone`=\''.$d['phone'].'\' OR `phone`=\''.$d['phone2'].'\'') ) {
                    $newObject = new Object;
                    $newObject->date_create = time();
                    $newObject->board_id = 2;
                    $newObject->url = $d['url'];
                    $newObject->name = $d['name'];
                    $newObject->desc = htmlspecialchars($d['desc']);
                    $newObject->street = $d['street'];
                    if ( strlen($d['street'])==0 ) {
                        $not_address++;
                    }
                    $newObject->house = $d['house'];
                    $newObject->type_id = $d['type_id'];
                    if ( strlen($d['type_id'])==0 ) {
                        $not_type++;
                    }
                    $newObject->area_id = $d['area_id'];
                    $newObject->daily = $d['daily'];
                    $newObject->price = $d['price'];
                    $newObject->furniture = $d['furniture'];
                    if ( strlen($d['phone'])==10 ) {
                        $newObject->phone = $d['phone'];
                    } 
                    if ( strlen($d['phone'])!=10 ) {
                        $not_phone++;
                    }
                    $newObject->repair = $d['repair'];
                    $newObject->origin = 2;
                    if ( $newObject->save() ) {
                        $count_total++;

                        if ( count($d['imgs'])!=0 ) {
                            foreach ( $d['imgs'] as $src ) {
                                $imageName = substr(md5($src.microtime()), 0, 28).'.jpg';
                                $temp = md5($src).'.jpg';
                                if ( copy($src, './uploads/temp/'.$temp) ) {
                                    $image = Yii::app()->image->load('./uploads/temp/'.$temp);
                                    $image->save('./uploads/object/'.$imageName);
                                    $image->resize(256, 256);
                                    $image->save('./uploads/object/preview/'.$imageName);
                                    $objectImage = new ObjectImage;
                                    $objectImage->object_id = $newObject->id;
                                    $objectImage->img = $imageName;
                                    $objectImage->save();
                                }
                            }
                        }

                    }
                } else {
                    $count_black++;
                } 
            }

            if ( $count_total!=0 || $count_black!=0 ) {
                $parserStatistic = new ParserStatistic;
                $parserStatistic->date = time();
                $parserStatistic->board_id = 2;
                $parserStatistic->count_total = $count_total;
                $parserStatistic->count_black = $count_black;
                $parserStatistic->not_address = $not_address;
                $parserStatistic->not_type = $not_type;
                $parserStatistic->not_phone = $not_phone;
                $parserStatistic->save();
            }

            $board->date_last_board = $first_adv_date;
            $board->update(array('date_last_board'));
        }
    }
    
    
    public function action_p_client_avito()
    {
        $url = 'https://m.avito.ru/omsk/kvartiry/snimu?user=1';
        
        include 'phpQuery.php';
        
        $board = Board::model()->findByPk('2');
        $date_last_board = ($board->date_last_board2!=null)?$board->date_last_board2:(time()-3600*24*2);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        
        $page = phpQuery::newDocumentHTML($result);
        $article = $page->find('article:eq(0)');

        $first_adv_date = $this->avito_date(trim(pq($article)->find('.info-date')->text()));
        $first_adv_link = 'https://m.avito.ru'.pq($article)->find('a')->attr('href');
        
        $current_date = $first_adv_date;
        $current_url = $first_adv_link;
        $prev_url = $url;
        
        $data = array();
        $_key = -1;
        
        while ( $current_date>$date_last_board ) {
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_URL, $current_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_REFERER, $prev_url);
            $result = curl_exec($ch);
            preg_match_all('/^Location:(.*)$/mi', $result, $matches);
            curl_close($ch);
            
            if ( strlen($matches[1][0])!=0 ) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_URL, 'https://m.avito.ru'.trim($matches[1][0]));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_REFERER, $prev_url);
                $result = curl_exec($ch);
                curl_close($ch);
            }
            
            $page = phpQuery::newDocumentHTML($result);
            
            $_key++;
            $data[$_key] = array(
                'url'=>$current_url,
                'name'=>'',
                'desc'=>'',
                'type_id'=>'',
                'area_id'=>'',
                'price'=>'',
                'daily'=>'',
                'phone'=>'',
                
                'date'=>'',
            );
            
            if ( strlen(trim($page->find('.person-name')->text()))!=0 ) {
                $data[$_key]['name'] = trim($page->find('.person-name')->text());
            } 
            if ( strlen(trim($page->find('.description-wrapper')->text()))!=0 ) {
                $data[$_key]['desc'] = trim($page->find('.description-wrapper')->text());
            }
            $fullAddress = trim($page->find('.address-person-params')->text());
            if ( strripos($fullAddress, 'Кировский')!==false ) {
                $data[$_key]['area_id'] = 2;
            } elseif ( strripos($fullAddress, 'Ленинский')!==false ) {
                $data[$_key]['area_id'] = 3;
            } elseif ( strripos($fullAddress, 'Октябрьский')!==false ) {
                $data[$_key]['area_id'] = 4;
            } elseif ( strripos($fullAddress, 'Советский')!==false ) {
                $data[$_key]['area_id'] = 5;
            } elseif ( strripos($fullAddress, 'Центральный')!==false ) {
                $data[$_key]['area_id'] = 6;
            }
            
            $mainDesc = trim($page->find('.single-item-header')->text());
            if ( strripos($mainDesc, '1-к квартиру')!==false ) {
                $data[$_key]['type_id'] = 1;
            } elseif ( strripos($mainDesc, '2-к квартиру')!==false ) {
                $data[$_key]['type_id'] = 2;
            }
            if ( strripos($mainDesc, 'посуточно')!==false ) {
                $data[$_key]['daily'] = 1;
            } else {
                $data[$_key]['daily'] = 0;
            }
            
            $data[$_key]['price'] = preg_replace('/\D/', '', trim($page->find('.price-value')->text()));
            
            $phoneLink = $page->find('.action-show-number a')->attr('href');
            if ( strlen($phoneLink)!=0 ) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
                curl_setopt($ch, CURLOPT_URL, 'https://m.avito.ru'.$phoneLink.'?async');
                curl_setopt($ch, CURLOPT_REFERER, (strlen($matches[1][0])!=0)?$matches[1][0]:$data[$_key]['url']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                
                $data[$_key]['phone'] = preg_replace('/\D/', '', curl_exec($ch));
                $data[$_key]['phone'] = substr($data[$_key]['phone'], 1);
                curl_close($ch);
            }
            
            $current_date = $this->avito_date($page->find('.item-add-date')->text());
            $prev_url = $current_url;
            $current_url = 'https://m.avito.ru'.$page->find('.page-next a')->attr('href');
            $data[$_key]['date'] = $page->find('.item-add-date')->text().'|'.($current_date-$date_last_board);
            
            sleep(10);
        }
        
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        
        if ( 1 ) {
            foreach ( $data as $d ) {
                
                if ( !BlackList::model()->find('`phone`=\''.$d['phone'].'\'') ) {
                    $client = new Client;
                    $client->date_create = time();
                    $client->fio = $d['name'];
                    $client->desc = $d['desc'];
                    $client->url = $d['url'];
                    $client->price = $d['price'];
                    $client->daily = $d['daily'];
                    $client->phone = $d['phone'];
                    $client->board_id = 2;
                    $client->origin = 2;
                    if ( $client->save() ) {
                        if ( strlen($d['type_id'])!=0 ) {
                            $relType = new RelClientObjectType;
                            $relType->client_id = $client->id;
                            $relType->objectType_id = $d['type_id'];
                            $relType->save();
                        }
                        if ( strlen($d['area_id'])!=0 ) {
                            $relArea = new RelClientArea;
                            $relArea->client_id = $client->id;
                            $relArea->area_id = $d['area_id'];
                            $relArea->save();
                        }
                    }
                }
            }
            
            $board->date_last_board2 = $first_adv_date;
            $board->update(array('date_last_board2'));
        }
        
    }
    
        
}