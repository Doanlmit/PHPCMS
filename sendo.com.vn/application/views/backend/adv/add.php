<section class="itq-tab">
    <h1>Thêm nhóm quảng cáo</h1>
    <ul>
        <li><a href="backend/adv/index" title="Quảng cáo">Quảng cáo</a></li>
        <li class="active"><a href="backend/adv/add" title="Thêm quảng cáo">Thêm quảng cáo</a></li>
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
                    <input type="text" name = "data[title]" value="<?php echo common_valuepost(isset($_post['title']) ? $_post['title'] : ''); ?>" class="txtText"/>
                </label>
                <label class="item">
                    <p class="label">Vị trí hiển thị</p>
                    <?php
                        echo form_dropdown('data[position]',array(
                                                                ''=>'---Chọn vị trí---', 
                                                                'Bên phải' => 'Bên phải',
                                                                'Bên trái' =>'Bên trái',
                                                                ), 
                        common_valuepost(isset($_post['position']) ? $_post['position'] : ''), 'class="cbSelect"');
                    ?>
                </label>
                <label class="item">
                    <p class="label">Nội dung:</p>
                    <textarea type="text" name="data[content]" class="mceEditor"><?php echo common_valuepost(isset($_post['content']) ? $_post['content'] : '') ?></textarea> 
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
                <section class="block">
                     <header>Thời gian</header>
                    <section class="container">                     
                        <label class="item">
                            <p class="label">Thời gian bắt đầu:</p>
                            <input type="text" name="data[time_start]" value="<?php echo common_valuepost(isset($_post['time_start']) ? $_post['time_start']:'')?>" class="txtText" id="txtTimestart"/>
                        </label>
                        <label class="item">
                            <p class="label">Thời gian kết thúc:</p>
                            <input type="text" name="data[time_end]" value="<?php echo common_valuepost(isset($_post['time_end']) ? $_post['time_end']:'')?>" class="txtText" id="txtTimesend"/>
                        </label>
                    </section>  
                </section><!--.block-->
        </aside><!--.aside-panel-->
    </form>
</section><!--.itq-form-->