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

    <section id="wrapper"><!-- Start #wrapper -->
        <section id="banner"><!-- Start #banner -->
        </section><!-- End #banner -->  
        <nav id="menu"><!--Start #menu-->
            <?php
               echo frontend_menu(
                            array('article_category' => frontend_menu_getdata('article_category'))
                                );
            ?>
        </nav><!--End #menu-->
        <section id="content"><!--Start #menu-->
            <section id="content-left">
                <section class="box">
                    <section class="box-left">
                        <img src="public/template/frontend/images/5-copy-0e579.jpg" alt="home">
                        <h2><a class="tieudetin" href="#">Giao thông Hà Nội “ngột ngạt” những ngày cận Tết</a></h2>
                        <p class="tomtattin">
                             Đại công trường của Dự án đường sắt đô thị trên cao đã “cướp” đi phần diện tích lớn trên nhiều tuyến đường, tình trạng đào đường vẫn diễn ra trên một số tuyến phố, lượng phương tiện tăng đột biến... khiến giao thông Hà Nội “ngột ngạt” vào những ngày cận Tết.
                        </p>
                    </section>
                    <section class="box-right">
                        <?php 
                            if(isset($title) && count($title)){
                               $str='<ul>';
                                foreach ($title as $key => $val) {
                           			$str = $str.'<li><a href="#">'.$val['title'].'</a></li>';
                                }
                                $str.='</ul>';
                            }
                            echo $str;
                        ?>
                    </section>
                    <section class="clear"></section>
                </section>
                <section class="box no-padding no-border" style="margin-top: 10px;">
                    <section class="box-title"><a href="#" title="sản phẩm">Tin tức</a></section>
                    <section class="box-left">
                        <img src="public/template/frontend/images/gioitre_180x108.jpg" alt="home">
                        <h2><a class="tieudetin" href="#">Giao thông Hà Nội “ngột ngạt” những ngày cận Tết</a></h2>
                        <p class="tomtattin">
                             Đại công trường của Dự án đường sắt đô thị trên cao đã “cướp” đi phần diện tích lớn trên nhiều tuyến đường, tình trạng đào đường vẫn diễn ra trên một số tuyến phố, lượng phương tiện tăng đột biến... khiến giao thông Hà Nội “ngột ngạt” vào những ngày cận Tết.
                        </p>
                    </section>
                    <section class="box-right" >
                        <section class="box-tin">
                            <img src="public/template/frontend/images/anh-cay-la.jpg" alt="anh1">
                            <p>
                                Xôn xao cây "lạ" cho hàng vạn quả
                            </p>
                            <section class="clear"></section>
                        </section>
                        <section class="box-tin">
                            <img src="public/template/frontend/images/usa-ukraine.png" alt="anh1">
                            <p>
                                Mỹ đứng ra đảm bảo cho Ukraine vay 1 tỷ USD
                            </p>
                            <section class="clear"></section>
                        </section>
                        <section class="box-tin">
                            <img src="public/template/frontend/images/ancelotti-ecff5.jpg" alt="anh1">
                            <p>
                                Người Real Madrid xin lỗi sau “thảm họa” trước Atletico
                            </p>
                            <section class="clear"></section>
                        </section>
                        <section class="box-tin">
                            <img src="public/template/frontend/images/img1.jpg" alt="anh1">
                            <p>
                                Tổng Bí thư Nguyễn Phú Trọng đánh trống khai hội báo Xuân 2015
                            </p>
                            <section class="clear"></section>
                        </section>
                    </section>
                    <section class="clear"></section>
                </section>
                <section class="box no-padding no-border" style="margin-top: 10px;">
                    <section class="box-title"><a href="#" title="sản phẩm">Sản phẩm</a></section>
                    <section class="box-left">
                        <img src="public/template/frontend/images/gioitre_180x108.jpg" alt="home">
                        <h2><a class="tieudetin" href="#">Giao thông Hà Nội “ngột ngạt” những ngày cận Tết</a></h2>
                        <p class="tomtattin">
                             Đại công trường của Dự án đường sắt đô thị trên cao đã “cướp” đi phần diện tích lớn trên nhiều tuyến đường, tình trạng đào đường vẫn diễn ra trên một số tuyến phố, lượng phương tiện tăng đột biến... khiến giao thông Hà Nội “ngột ngạt” vào những ngày cận Tết.
                        </p>
                    </section>
                    <section class="box-right" >
                        <section class="box-tin">
                            <img src="public/template/frontend/images/anh-cay-la.jpg" alt="anh1">
                            <p>
                                Xôn xao cây "lạ" cho hàng vạn quả
                            </p>
                            <section class="clear"></section>
                        </section>
                        <section class="box-tin">
                            <img src="public/template/frontend/images/usa-ukraine.png" alt="anh1">
                            <p>
                                Mỹ đứng ra đảm bảo cho Ukraine vay 1 tỷ USD
                            </p>
                            <section class="clear"></section>
                        </section>
                        <section class="box-tin">
                            <img src="public/template/frontend/images/ancelotti-ecff5.jpg" alt="anh1">
                            <p>
                                Người Real Madrid xin lỗi sau “thảm họa” trước Atletico
                            </p>
                            <section class="clear"></section>
                        </section>
                        <section class="box-tin">
                            <img src="public/template/frontend/images/img1.jpg" alt="anh1">
                            <p>
                                Tổng Bí thư Nguyễn Phú Trọng đánh trống khai hội báo Xuân 2015
                            </p>
                            <section class="clear"></section>
                        </section>
                    </section>
                    <section class="clear"></section>
                </section>
            </section>

            <section id="content-right">
                <section class="box no-padding no-border ">
                    <section class="box-title">
                        <a href="#">Tin cập nhật</a>
                    </section>
                </section>
                <section class="box-right " style="width: 100%;">
                    <section class="box-tin">
                        <img src="public/template/frontend/images/img1.jpg" alt="anh1">
                        <p>
                            Tổng Bí thư Nguyễn Phú Trọng đánh trống khai hội báo Xuân 2015
                        </p>
                        <section class="clear"></section>
                    </section>
                    <section class="box-tin">
                            <img src="public/template/frontend/images/1-a797b.jpg" alt="anh1">
                            <p>
                                Trong hiệp đấu đầu tiên, chỉ có một bàn thắng được ghi, đó là pha lập công của Ozil ở phút 11.
                            </p>
                        <section class="clear"></section>
                    </section>
                    <section class="box-tin">
                            <img src="public/template/frontend/images/Chuc_danh_gs_QTAT-226c2.jpg" alt="anh1">
                            <p>
                                Các cơ sở đào tạo không nên vì muốn có được số lượng giảng viên chất lượng cao hay đạt tiêu chí mở ngành nghề mà để xảy ra“chạy đua” lên GS, PGS.
                            </p>
                        <section class="clear"></section>
                    </section>
                    <section class="box-tin">
                        <img src="public/template/frontend/images/Kayla-Jean-Mueller-69a2d.jpg" alt="anh4">
                        <p>
                             Ngày 6/2, nhóm Hồi giáo cực đoan IS khẳng định con tin người Mỹ duy nhất còn bị nhóm này giam giữ đã thiệt mạng trong một vụ không kích của không quân Jordan. 
                        </p>
                    </section>
                </section>
                <section id="adv-right">
                    <ul>
                        <li><img src="public/template/frontend/images/danongvaobep-ba7ab.jpg" alt="danong" style="width: 100%;"></li>
                        <li><img src="public/template/frontend/images/rau-sach.jpg" alt="danong" style="width: 100%;"></li>
                        <li><img src="public/template/frontend/images/canh-sat.jpg" alt="danong" style="width: 100%;"></li>
                    
                    </ul>
                </section>
            </section>
            <section class="clear"></section>
        </section><!--End #content-->
        
        <section id="footer">
            <section id="footer-left">
                <p>Cơ quan của TW Hội Khuyến học Việt Nam</p>
                <p>Giấy phép hoạt động báo điện tử Dân trí trên Internet số 378/GP - BTTTT Hà Nội, ngày 16-09-2013.</p>
                <p>Tòa soạn: Số 2 (nhà 48) Giảng Võ, Quận Đống Đa, Hà Nội</p>
                <p>Điện thoại: 04-3736-6491. Fax: 04-3736-6490</p>
                <p>Email: info@dantri.com.vn. Website: http://www.dantri.com.vn</p> 
                <p>Mọi hành động sử dụng nội dung đăng tải trên Báo điện tử Dân trí tại địa chỉ www.dantri.</p>
                <p>com.vn phải có sự đồng ý bằng văn bản của Báo điện tử Dân trí.</p>
            </section>
            <section id="footer-right">
                <p>Đơn vị quảng cáo:</p>  
                    <p>01287 078 866 (Ms.Luận)</p>
                    <p>Email: quangcao@admicro.vn</p>
                    <p>Tel: 844 39748899 Ext:2233 Website: www.admicro.vn</p>
                    <p>Hỗ trợ và CSKH: 01268 269 779 (Ms. Thơm)</p>
                    <p>Các mảng: gia đình - công nghệ - game - giải trí , xã hội.
                </p>
            </section>
        </section>
    </section><!-- End #wrapper -->

</body>
</html>