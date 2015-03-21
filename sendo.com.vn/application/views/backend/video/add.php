<section class="itq-tab">
    <h1>Thêm liên kết</h1>
    <ul>
        <li><a href="backend/link/index" title="liên kết">liên kết</a></li>
        <li class="active"><a href="backend/link/add" title="Thêm liên kết">Thêm liên kết</a></li>
    </ul>
</section>
<section class="itq-form">
     <form method="post" action="">
        <section class="main-panel">
           <header>Thông tin chung</header>
            <?php echo common_showerror(validation_errors()); ?>
            <section class="block">
                <label class="item">
                    <p class="label">Tiêu đề:</p>
                    <input type="text" name = "data[title]" value="<?php echo common_valuepost(isset($_post['title']) ? $_post['title'] : ''); ?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Mã video:</p>
                    <input type="text" name = "data[code]" value="<?php echo common_valuepost(isset($_post['code']) ? $_post['code'] : '');?>" class="txtText"/>
                </label>
                <section class="action"><!--.action-->
                    <p class="label">Thao tác:</p>
                    <section class="group">
                        <input type="submit" name="add" value="Thêm mới"/>
                        <input type="submit" name="reset" value="Làm lại"/>
                    </section>					
                </section>
            </section><!--.block-->
        </section><!--.main-panel-->
        <aside class="side-panel">
                <section class="block">
                    <header>Nâng cao</header>
                    <section class="container">                     
                            <section class="checkbox-radio">
                                <p class="label">Hiển thị:</p>
                                <section class="group"> 
                                    <label><input type="radio" name="data[publish]" value="1"<?php echo common_valuepost(isset($_post['publish']) ? (($_post['publish'] == 1) ? 'checked="checked"' : ''):'');?>class=""/><span>Bật</span></label>
                                    <label><input type="radio" name="data[publish]" value="0"<?php echo common_valuepost(isset($_post['publish']) ? (($_post['publish'] == 0) ? 'checked="checked"' : ''):'');?>class=""/><span>Tắt</span></label>
                                </section>
                            </section><!--.checkbox-radio-->
                    </section>  
                </section><!--.block-->

        </aside><!--.aside-panel-->
    </form>
</section><!--.itq-form-->