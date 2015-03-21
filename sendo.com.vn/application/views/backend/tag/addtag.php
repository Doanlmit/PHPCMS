<section class="itq-tab">
    <h1>Thêm chủ đề</h1>
    <ul>
        <li><a href="backend/tag/index" title="Chủ đề">Chủ đề</a></li>
        <li class="active"><a href="backend/tag/addtag" title="Thêm chủ đề">Thêm chủ đề</a></li>
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
                    <p class="label">Mô tả:</p>
                    <textarea type="text" name="data[description]" value="<?php echo common_valuepost(isset($_post['description']) ? $_post['description'] : '') ?>" class="mceEditor"></textarea> 
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
                <section class="block">
                     <header>SEO</header>
                    <section class="container">                     
                        <label class="item">
                            <p class="label">Meta title</p>
                            <input type="text" name="data[meta_title]" value="<?php echo common_valuepost(isset($_post['meta_title']) ? $_post['meta_title']:'')?>" class="txtText"/>
                        </label>
                        <label class="item">
                            <p class="label">Meta Keywords:</p>
                            <input type="text" name="data[meta_keywords]" value="<?php echo common_valuepost(isset($_post['meta_keywords']) ? $_post['meta_keywords']:'')?>" class="txtText"/>
                        </label>
                            <label class="item">
                            <p class="label">Meta Descriptions:</p>
                                <textarea type="text" name="data[meta_descriptions]" value="" class="txtText"><?php echo common_valuepost(isset($_post['meta_descriptions']) ? $_post['meta_descriptions'] : '') ?></textarea> 
                        </label>
                    
                    </section>  
        </aside><!--.aside-panel-->
    </form>
</section><!--.itq-form-->