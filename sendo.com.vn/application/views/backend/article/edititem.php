<section class="itq-tab">
    <h1>Sửa bài viết</h1>
    <ul>
        <li><a href="backend/article/item" title="Bài viết">Bài viết</a></li>
        <li class="active"><a href="backend/article/additem" title="Sửa bài viết">Sửa bài viết</a></li>
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
                    <input type="text" name = "data[title]" value="<?php echo common_valuepost(isset($_post['title']) ? $_post['title'] : 'ada'); ?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Danh mục cha</p>
                    <?php echo form_dropdown('data[parentid]', 
                          (isset($_show['parentid']) ? $_show['parentid']:NULL), 
                          common_valuepost(isset($_post['parentid']) ? $_post['parentid']:0), 
                          'class="cbSelect"');?>

                </label>
                <label class="item">
                    <p class="label">Chủ đề</p>
                    <input type="text" name = "data[tags]" value="<?php echo common_valuepost(isset($_post['tags']) ? $_post['tags'] : ''); ?>" class="txtText" id="txtTags"/>
                    <input type="button" value="Chọn" class="btnButton" id="tags-suggest"/>
                    <section id="tagspicker-suggest"></section>
                </label>
                <label class="item">
                    <p class="label">Ảnh đại diện:</p>
                    <input type="text" name = "data[image]" value="<?php echo common_valuepost(isset($_post['image']) ? $_post['image'] : '');?>"class="txtText" id="txtImage" />
                    <input type="button" value="Chọn" class="btnButton" onclick="browserKCFinder('txtImage', 'image'); return false;" />
                </label>
                <label class="item">
                    <p class="label">Mô tả:</p>
                    <textarea type="text" name="data[description]" class="mceEditor"><?php echo common_valuepost(isset($_post['description']) ? $_post['description'] : '') ?></textarea> 
                </label>
                <label class="item">
                    <p class="label">Nội dung:</p>
                    <textarea type="text" id="editor" name="data[content]" class="mceEditor"><?php echo common_valuepost(isset($_post['content']) ? $_post['content'] : '') ?></textarea> 
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
                    <section class="container">                     
                            <section class="checkbox-radio">
                                <p class="label">Nổi bật:</p>
                                <section class="group"> 
                                    <label><input type="radio" name="data[highlight]" value="1"<?php echo common_valuepost(isset($_post['highlight']) ? (($_post['highlight'] == 1) ? 'checked="checked"' : ''):'');?>class=""/><span>Bật</span></label>
                                    <label><input type="radio" name="data[highlight]" value="0"<?php echo common_valuepost(isset($_post['highlight']) ? (($_post['highlight'] == 0) ? 'checked="checked"' : ''):'');?>class=""/><span>Tắt</span></label>
                                </section>
                            </section><!--.checkbox-radio-->
                    </section>  
                </section><!--.block-->
                <section class="block">
                     <header>Thời gian</header>
                    <section class="container">                     
                        <label class="item">
                            <p class="label">Thời gian hiển thị:</p>
                            <input type="text" name="data[timer]" value="<?php echo common_valuepost(isset($_post['timer']) ? $_post['timer']:'')?>" class="txtText" id="txtTimer"/>
                        </label>
                    </section>  
                </section><!--.block-->
                <section class="block">
                     <header>SEO</header>
                    <section class="container">                     
                        <label class="item">
                            <p class="label"></p>
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
                </section><!--.block-->
                <section class="block">
                    <header>Khác</header>
                    <section class="container">                     
                        <label class="item">
                            <p class="label">Nguồn:</p>
                            <textarea type="text" name="data[source]" value="" class="txtText"><?php echo common_valuepost(isset($_post['source']) ? $_post['source'] : '') ?></textarea> 
                        </label>
                         <label class="item">
                            <p class="label">Link tùy biến:</p>
                                <input type="text" name="data[route]" value="<?php echo common_valuepost(isset($_post['route']) ? $_post['route'] : '') ?>" class="txtText"/>
                        </label>
                    </section>
                </section>    
        </aside><!--.aside-panel-->
     </form>
</section><!--.itq-form-->