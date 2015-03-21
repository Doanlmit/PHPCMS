<section class="vts-wrapper">
    <form method="post" action="">
        <fieldset>
            <legend>Tạo tài khoản quản trị:</legend>
            <?php echo common_showerror(validation_errors()); ?>
            <label><p>Tên sử dụng:</p><input type="text" name="data[username]" value="<?php echo common_valuepost(isset($_post['username']) ? $_post['username'] : ''); ?>" class="txtUsername"></label>
            <label><p>Mật khẩu:</p><input type="password" name="data[password]" value="<?php echo common_valuepost(isset($_post['password']) ? $_post['password'] : ''); ?>" class="txtPassword"></label>
            <label><p>Email:</p><input type="text" name="data[email]" value="<?php echo common_valuepost(isset($_post['email']) ? $_post['email'] : ''); ?>" class="txtEmail"></label>

            <section><input type="submit" name="create" value="Tạo mới" class="btnCreate"/><input type="reset" name="reset" value="Đặt lại" class=""/>
            </section>
            <nav>
                <ul>
                    <li><a href="<?php echo ITQ_BASE_URL ?>" title="Về trang chủ">Về trang chủ</a></li>
                </ul>
            </nav>
        </fieldset>
    </form>
</section><!--.vts-wraper-->