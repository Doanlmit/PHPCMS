<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo isset($seo['title']) ? htmlspecialchars($seo['title']) : ''; ?></title>
        <meta name="keywords" content = "<?php echo isset($seo['keywords']) ? htmlspecialchars($seo['keywords']) : ''; ?>"/>	
        <meta name="desciption" content = "<?php echo isset($seo['desciption']) ? htmlspecialchars($seo['desciption']) : ''; ?>"/>
        <base href="<?php echo CMS_BASE_URL ?>"/>
        <link rel="stylesheet" href="public/template/backend/css/normalize.css" type="text/css" media="all" />
        <link rel="stylesheet" href="public/template/backend/css/login.css" type="text/css" media="all" />
        <?php $this->load->view($template, isset($data) ? $data : NULL); ?>
    </head>
    <body>
        <footer><p>copyright &copy; <?php echo gmdate('Y', time() + 7 * 3600); ?> powered by <a href="http://php.net/" title="Thiết kế website, dịch vụ seo" target="_blank">Harvey Nash Việt Nam</a></p></footer>
    </body>
</html>