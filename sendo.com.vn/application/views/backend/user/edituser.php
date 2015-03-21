<section class="itq-tab">
    <h1>Sửa thành viên</h1>
    <ul>
        <li><a href="backend/user/index" title="Thành viên">Thành viên</a></li>
        <li class="active"><a href="backend/user/adduser" title="Sửa thành viên">Sửa thành viên</a></li>
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
                    <input type="text" name = "" value="<?php echo $data['user']?>" disabled="" readonly="true"class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Email:</p>
                    <input type="email" name="data[email]" value="<?php echo common_valuepost(isset($_post['email']) ? $_post['email'] : ''); ?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Nhóm thành viên:</p>
                    <?php echo form_dropdown('data[groupid]', 
                                            (isset($_show['groupid']) ? $_show['groupid']:NULL), 
                                            common_valuepost(isset($_post['groupid']) ? $_post['groupid']:0), 
                                            'class="cbSelect"');
                    ?>
                </label>
                <label class="item">
                    <p class="label">Google_author:</p>
                    <input type="text" name="data[google_author]" value="<?php echo common_valuepost(isset($_post['google_author']) ? $_post['google_author']:'');?> " class="txtText"/>
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
    </form>
</section><!--.itq-form-->