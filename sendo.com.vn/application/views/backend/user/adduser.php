<section class="itq-tab">
    <h1>Thêm thành viên</h1>
    <ul>
        <li><a href="backend/user/index" title="Thành viên">Thành viên</a></li>
        <li class="active"><a href="backend/user/adduser" title="Thêm thành viên">Thêm thành viên</a></li>
    </ul>
</section>
<section class="itq-form">
    <form method="post" action="">
        <section class="main-panel main-panel-single">
            <header>Thông tin chung</header>
            <?php echo common_showerror(validation_errors()); ?>
            <section class="block">
                <label class="item">
                    <p class="label">Tên sử dụng:</p>
                    <input type="text" name = "data[username]" value="<?php echo common_valuepost(isset($_post['username']) ? $_post['username'] : '');?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Mật khẩu:</p>
                    <input type="password" name = "data[password]" value="<?php echo common_valuepost(isset($_post['password']) ? $_post['password'] : ''); ?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Xác nhận mật khẩu:</p>
                    <input type="password" name = "data[repassword]" value="<?php echo common_valuepost(isset($_post['repassword']) ? $_post['repassword'] : ''); ?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Email:</p>
                    <input type="email" name="data[email]" value="<?php echo common_valuepost(isset($_post['email']) ? $_post['email'] : ''); ?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Nhóm thành viên:</p>
                    <?php echo form_dropdown('data[groupid]', isset($_show['groupid']) ? $_show['groupid'] : NULL
                                                      , common_valuepost(isset($_groupid) ? $_groupid : '')
                                                      , 'class="cbSelect"')?>
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
    </form>
</section><!--.itq-form-->