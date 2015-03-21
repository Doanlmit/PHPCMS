<section class="vts-wrapper">
    <form method="post" action="">
        <fieldset>
            <legend>Đăng nhập hệ thống:</legend>
            <?php echo common_showerror(validation_errors()); ?>
            <label><p>Tên sử dụng:</p><input type="text" name="data[username]" value="<?php echo common_valuepost(isset($_post['username']) ? $_post['username'] : ''); ?>" class="txtUsername"></label>
            <label><p>Mật khẩu:</p><input type="password" name="data[password]" value="<?php echo common_valuepost(isset($_post['password']) ? $_post['password'] : ''); ?>" class="txtPassword"></label>
            <section><input type="submit" name="login" value="Đăng nhập" class="btnLogin"/><input type="reset" name="reset" value="Đặt lại" class=""/>
            </section>
            <nav>
                <ul>
                    <li><a href="<?php echo CMS_BASE_URL?>backend/auth/forgot" title="Quên mật khẩu">Quên mật khẩu</a></li>
                    <li><a href="<?php echo CMS_BASE_URL?>" title="Về trang chủ">Về trang chủ</a></li>
                </ul>
            </nav>
        </fieldset>
    </form>
</section><!--.vts-wraper-->