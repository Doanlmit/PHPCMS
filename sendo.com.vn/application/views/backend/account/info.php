<section class="itq-tab">
    <h1>Thay đổi thông tin tài khoản</h1>
</section>
<section class="itq-form">
    <section class="main-panel main-panel-single">
        <?php echo common_showerror(validation_errors());?>
        <form method="post" action="">
            <header>Thông tin chung</header>
            <section class="block">
                <label class="item">
                    <p class="label">Tên sử dụng:</p>
                    <input type="text" value="<?php echo $data['auth']['username'];?>" class="txtText" disabled/>
                </label>
                <label class="item">
                    <p class="label">Email:</p>
                    <input type="text" name="data[email]" value="<?php echo common_valuepost(isset($_post['email']) ? $_post['email'] : '');?>" class="txtText"/>    
                </label>
                <label class="item">
                    <p class="label">Tên đầy đủ:</p>
                    <input type="text" name="data[fullname]" value="<?php echo common_valuepost(isset($_post['fullname']) ? $_post['fullname'] : '');?>" class="txtText"/> 
                </label>
                <label class="item">
                    <p class="label">Google Author:</p>
                    <input type="text" name="data[google_author]" value="<?php echo common_valuepost(isset($_post['google_author']) ? $_post['google_author'] : '');?>" class="txtText"/> 
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