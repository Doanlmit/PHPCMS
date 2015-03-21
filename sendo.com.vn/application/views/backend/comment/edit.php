<section class="itq-tab">
    <h1>Sửa comment</h1>
    <ul>
        <li><a href="backend/comment/index" title="Bình luận">link</a></li>
        <li class="active"><a href="backend/link/edit" title="Sửa bình luận">Sửa comment</a></li>
    </ul>
</section>
<section class="itq-form">
     <form method="post" action="">
        <section class="main-panel">
           <header>Thông tin chung</header>
            <?php echo common_showerror(validation_errors()); ?>
            <section class="block">
                <label class="item">
                    <p class="label">Họ và tên:</p>
                    <input type="text" name = "data[fullname]" value="<?php echo common_valuepost(isset($_post['fullname']) ? $_post['fullname'] : ''); ?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Email:</p>
                    <input type="text" name = "data[email]" value="<?php echo common_valuepost(isset($_post['email']) ? $_post['email'] : '');?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Nội dung:</p>
                    <textarea rows="10" cols="6" type="text" name = "data[content]" class="txtText"><?php echo common_valuepost(isset($_post['content']) ? $_post['content'] : '');?></textarea>
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