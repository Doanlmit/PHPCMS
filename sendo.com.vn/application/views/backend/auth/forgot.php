<section class="vts-wrapper">
    <form method="post" action="">
        <fieldset>
            <legend>QUÊN THÔNG TIN TÀI KHOẢN</legend>
            <?php echo common_showerror(validation_errors()); ?>
            <label><p class="email">Email:</p><input type="text" name="data[email]" value="<?php common_valuepost(isset($_post['email']) ? $_post['email'] : '');?>" class="email"></label>
            <section><input type="submit" name="forgot" value="Gửi mã xác nhận" class="btnForgot"/><input type="reset" name="reset" value="Đặt lại" class=""/>
            </section>
            <nav>
                <ul>
                    <li><a href="<?php echo CMS_BASE_URL; ?>" title="Về trang chủ">Về trang chủ</a></li>
                    <li>/</li>
                    <li><a href="<?php echo CMS_BASE_URL; ?>backend/auth/login" title="Quên mật khẩu">Đăng nhập</a></li>
                </ul>
            </nav>
        </fieldset>
    </form>
</section><!--.vts-wraper-->
