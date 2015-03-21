<section class="itq-tab">
    <h1> danh mục</h1>
    <ul>
        <li><a href="backend/article/index" title="Danh mục">Danh mục</a></li>
        <li class="active"><a href="backend/article/addcategory" title="Thêm danh mục">Thêm danh mục</a></li>
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
                    <p class="label">Danh mục cha</p>
                    <?php echo form_dropdown('data[parentid]', 
                          (isset($_show['parentid']) ? $_show['parentid']:NULL), 
                          common_valuepost(isset($_post['parentid']) ? $_post['parentid']:0), 
                          'class="cbSelect"');?>
                </label>
                <label class="item">
                    <p class="label">Mô tả:</p>
                    <textarea type="text" name="data[description]" class="mceEditor"><?php echo common_valuepost(isset($_post['description']) ? $_post['description'] : '') ?></textarea> 
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
                <section class="block">
                     <header>SEO</header>
                    <section class="container">                     
                        <label class="item">
                            <p class="label">Meta Title:</p>
                            <input type="text" name="data[meta_title]" value="<?php echo common_valuepost(isset($_post['meta_title']) ? $_post['meta_title']:'')?>" class="txtText"/>
                        </label>
                        <label class="item">
                            <p class="label">Meta Keywords:</p>
                            <input type="text" name="data[meta_keywords]" value="<?php echo common_valuepost(isset($_post['meta_keywords']) ? $_post['meta_keywords']:'')?>" class="txtText"/>
                        </label>
                        <label class="item">
                            <p class="label">Meta Descriptions:</p>
                            <textarea rows="8" type="text" name="data[meta_descriptions]" class="txtText"><?php echo common_valuepost( isset($_post['meta_descriptions']) ? $_post['meta_descriptions']:'');?></textarea> 
                        </label>
                        <label class="item">
                            <p class="label">Link tùy biến:</p>
                            <input type="text" name="data[route]" value="<?php echo common_valuepost(isset($_post['route']) ? $_post['route'] : '');?>" class="txtText"/>
                        </label>
                    </section>  
                </section><!--.block-->
               
        </aside><!--.aside-panel-->
    </form>
</section><!--.itq-form-->