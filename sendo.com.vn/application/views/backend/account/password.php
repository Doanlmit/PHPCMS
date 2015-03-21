<section class="itq-tab">
    <h1>Thay đổi thông mật khẩu</h1>
    <ul>
        <li><a href="backend/account/info"  title="Thay đổi thông tin tài khoản">Thông tin</a></li>
        <li class="active"><a href="backend/account/password" title="Thay đổi thông tin mật khẩu">Mật khẩu</a></li>
    </ul>
</section>
<section class="itq-form">
    <section class="main-panel">
        <?php echo common_showerror(validation_errors());?>
        <form method="post" action="">
            <header>Thông tin chung</header>
            <section class="block">
                <label class="item">
                    <p class="label">Tên sử dụng:</p>
                    <input type="text" name = "data[username]" value="<?php echo $data['auth']['username'];?>" class="txtText" disabled/>
                </label>
                <label class="item">
                    <p class="label">Mật khẩu cũ:</p>
                    <input type="password" name="data[oldpassword]" value="<?php echo common_valuepost(isset($_post['oldpassword']) ? $_post['oldpassword'] : '');?>" class="txtText"/>    
                </label>
               <label class="item">
                    <p class="label">Mật khẩu mới:</p>
                    <input type="password" name="data[newpassword]" value="<?php echo common_valuepost(isset($_post['newpassword']) ? $_post['newpassword'] : '');?>" class="txtText"/>    
                </label>
                <label class="item">
                    <p class="label">Xác nhận mật khẩu mới:</p>
                    <input type="password" name="data[repassword]" value="<?php echo common_valuepost(isset($_post['repassword']) ? $_post['repassword'] : '');?>" class="txtText"/>    
                </label>
                <section class="action"><!--.action-->
                    <p class="label">Thao tác:</p>
                    <section class="group">
                        <input type="submit" name="change" value="Thay đổi"/>
                        <input type="submit" name="reset" value="Làm lại"/>
                    </section>					
                </section>
            </section><!--.block-->

        </form>
    </section><!--.main-panel-->
</section><!--.itq-form-->