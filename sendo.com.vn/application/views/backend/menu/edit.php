<section class="itq-tab">
    <h1>Sửa menu</h1>
    <ul>
        <li><a href="backend/menu/index" title="Menu">Menu</a></li>
        <li class="active"><a href="backend/menu/edit" title="Sửa menu">Sửa menu</a></li>
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
                    <p class="label">Url:</p>
                    <input type="text" name = "data[url]" value="<?php echo common_valuepost(isset($_post['url']) ? $_post['url'] : '');?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Module:</p>
                    <input type="text" name="data[module]" value="<?php echo common_valuepost(isset($_post['module']) ? $_post['module'] : '');?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Module ID:</p>
                    <input type="text" name="data[module_id]" value="<?php echo common_valuepost(isset($_post['module_id']) ? $_post['module_id'] : '');?>" class="txtText"/>
                </label>
                <section class="action"><!--.action-->
                    <p class="label">Thao tác:</p>
                    <section class="group">
                        <input type="submit" name="edit" value="Thay đổi"/>
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