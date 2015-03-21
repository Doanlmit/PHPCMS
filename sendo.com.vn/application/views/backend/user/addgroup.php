<section class="itq-tab">
    <h1>Thêm nhóm thành viên</h1>
    <ul>
        <li><a href="backend/user/group" title="Nhóm thành viên">Nhóm thành viên</a></li>
        <li class="active"><a href="backend/user/addgroup" title="Thêm nhóm thành viên">Thêm nhóm thành viên</a></li>
    </ul>
</section>
<section class="itq-form">
    <section class="main-panel main-panel-single">
        <form method="post" action="">
            <header>Thông tin chung</header>
            <?php echo common_showerror(validation_errors()); ?>
            <section class="block">
                <label class="item">
                    <p class="label">Tiêu đề:</p>
                    <input type="text" name = "data[title]" value="<?php echo common_valuepost(isset($_post['title']) ? $_post['title'] : ''); ?>" class="txtText"/>
                </label>
                <section class="checkbox-radio">
                    <p class="label">Cho phép:</p>
                    <section class="group">
                        <label><input type="radio" name="data[allow]" value="1" <?php echo common_valuepost(isset($_post['allow']) ? (($_post['allow'] == 1) ? 'checked = "checked"' : '') : ''); ?>/><span>Cho phép</span></label>
                        <label><input type="radio" name="data[allow]" value="0" <?php echo common_valuepost(isset($_post['allow']) ? (($_post['allow'] == 0) ? 'checked = "checked"' : '') : ''); ?>/><span>Không cho phép</span></label>
                    </section>
                </section><!--.checkbox-radio-->
                <label class="item">
                    <p class="label">Nội dung:</p>
                    <textarea type="text" name="data[group]" value="<?php echo common_valuepost(isset($_post['group']) ? $_post['group'] : '') ?>" class="mceEditor"></textarea> 
                </label>
                <section class="action"><!--.action-->
                    <p class="label">Thao tác:</p>
                    <section class="group">
                        <input type="submit" name="add" value="Thêm mới"/>
                        <input type="submit" name="reset" value="Làm lại"/>
                    </section>					
                </section>
            </section><!--.block-->
        </form>
    </section><!--.main-panel-->
</section><!--.itq-form-->