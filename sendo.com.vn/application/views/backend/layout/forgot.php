<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($seo['title'])?htmlspecialchars($seo['title']):'';?></title>
<meta name="keywords" content="<?php echo isset($seo['keywords'])?htmlspecialchars($seo['keywords']):'';?>"/>	
<meta name="description" content="<?php echo isset($seo['description'])?htmlspecialchars($seo['description']):'';?>"/>
<base href="<?php echo CMS_BASE_URL;?>"/>
<link rel="stylesheet" href="public/template/backend/css/normalize.css" type="text/css" media="all" />
<link rel="stylesheet" href="public/template/backend/css/login.css" type="text/css" media="all" />
</head>
<body>
    <header></header>
	<?php $this->load->view($template, isset($data)?$data:NULL); ?>
    <footer><p>copyright &copy; <?php echo gmdate('Y', time() + 7 * 3600); ?> powered by <a href="http://itq.vn/" title="Thiết kế website, dịch vụ seo" target="_blank">FSoft</a></p></footer>
 </body>
</html>