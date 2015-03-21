<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width">
    <title><?php echo isset($seo['title']) ? htmlspecialchars($seo['title']) : '' ?></title>
    <meta name="keywords" content = "<?php echo isset($seo['keywords']) ? $seo['keywords'] : '';?>"/>	
    <meta name="description" content = "<?php echo isset($seo['descriptions']) ? $seo['descriptions'] : '';?>"/>
    <?php echo isset($seo['canonical'])? '<link rel="canonical" href="'.$seo['canonical'].'" />' : '';?>
    <link rel="stylesheet" href="public/template/frontend/css/normalize.css" type="text/css" media="all" />
    <link rel="stylesheet" href="public/template/frontend/css/style.css" type="text/css" media="all" />
    <?php echo (isset($seo['re_prev']) && !empty($seo['re_prev'])) ? '<link rel="prev" href="'.$seo['re_prev'].'" />'."\n" : '';?>
    <?php echo (isset($seo['re_next']) && !empty($seo['re_prev'])) ? '<link rel="next" href="'.$seo['re_next'].'" />'."\n" : '';?>
    <?php echo (isset($seo['_author']['google_author']) && !empty($seo['_author']['google_author'])) ? '<link rel="author" href="'.$seo['_author']['google_author'].'" />'."\n" : ((isset($this->_config['google_autoship']) && isset($this->_config['google_autoship'])) ? '<link rel="autoship" href="'.$this->_config['google_autoship'].'" />'."\n" : '');?>
    <?php echo (isset($this->_config['google_publish']) && isset($this->_config['google_publish'])) ? '<link rel="publish" href="'.$this->_config['google_publish'].'" />'."\n" : '';?>
    <base href="<?php echo CMS_BASE_URL; ?>"/>
</head>
<body>
<?php
	/**** SET LANGUAGE ****/
    echo $this->lang->line('ft_hello').'<br/>';
    echo $this->lang->line('ft_logout').'<br/>';
    $_lang = $this->session->userdata('_lang');
    echo 'Ngon ngu hien tai: '.$_lang;
?>
 <ul class="lang">
            <?php
                $_lang = $this->session->userdata('_lang');
                $lang = array(
                    'jp' => 'Tiếng Nhật',
                    'en' => 'Tiếng Anh',
                    'vi' => 'Tiếng Việt',
                );
                foreach ($lang as $key => $val) {
                    if ($_lang == $key) {
                        //echo '<li><a href="backend/home/lang/'.$key.'" title="'.$val.'">[' . $key . ']</a></li>';
                        echo '<li><a href="'.$key.CMS_URL_SUFFIX.'" title="'.$val.'"><img src="public/template/backend/images/'.$key.'.jpg"/> </a></li>';
                    }else {
                        echo '<li><a href="'.$key.CMS_URL_SUFFIX.'" title="'.$val.'">' . $key . '</a></li>';
                    
                    }
                }
            ?>    
            
        </ul>
<?php
	/**** SET MENU CALL METHOD frontend_menu_getdata IN frontend_helper ****/
    echo frontend_menu(
                            array('article_category' => frontend_menu_getdata('article_category'))
                      
                        );
?>
<?php
	/**** SET LAYOUT IN VIEW ****/ 
	$this->load->view($template, isset($data) ? $data : NULL)
?>
</body>
</html>	