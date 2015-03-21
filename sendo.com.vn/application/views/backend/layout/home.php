<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width">
    <title><?php echo isset($seo['title']) ? htmlspecialchars($seo['title']) : '' ?></title>
    <meta name="keywords" content = ""/>	
    <meta name="description" content = ""/>
    <base href="<?php echo CMS_BASE_URL; ?>"/>
    <link rel="stylesheet" href="public/template/backend/css/normalize.css" type="text/css" media="all" />
    <link rel="stylesheet" href="public/template/backend/css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="public/template/backend/plugins/datetimepicker/jquery.datetimepicker.css"/>
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <script type="text/javascript" src="public/template/backend/js/1.7.2.jquery.min.js"></script>
</head>
<body>
    <header class="itq-header">
        <p class="main-title">Hệ thống quản trị nội dung CMS Harvey Nash Việt Nam</p>
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
                        echo '<li><a href="backend/home/lang/'.$key.'?continue='.base64_encode(common_fullurl()).'" title="'.$val.'"><img src="public/template/backend/images/'.$key.'.jpg"/> </a></li>';
                    }else {
                        echo '<li><a href="backend/home/lang/'.$key.'?continue='.base64_encode(common_fullurl()).'" title="'.$val.'">' . $key . '</a></li>';
                    
                    }
                }
            ?>    
            
        </ul>
        
    </header>
        <?php $this->load->view('backend/common/nav'); ?>
        <?php $this->load->view($template, isset($data) ? $data : NULL) ?>
    <footer><p>copyright &copy; <?php echo gmdate('Y', time() + 7 * 3600); ?> powered by <a href="http://php.net/" title="Thiết kế website, dịch vụ seo" target="_blank">Harvey Nash Việt Nam</a></p></footer>
</body>
<script type="text/javascript" src="public/template/backend/plugins/datetimepicker/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="public/template/backend/js/global.js"></script>
<?php $this->load->view('backend/common/tinymce') ?>
</html>