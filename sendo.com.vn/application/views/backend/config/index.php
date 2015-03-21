<?php
    $_lang = $this->session->userdata('_lang');
?>
<section class="itq-tab">
    <h1>Cấu hình hệ thống</h1>
	<?php
            $_tabs = array(
                            'ftp' => 'FTP',
                            'seo' => 'SEO',
            				'contact' => 'Liên hệ',
			    			'frontend' => 'Trang chủ'
			    		);
		echo '<ul>';		
              	foreach($_tabs as $key=> $val){
                	echo '<li '.(($_group == $key) ? ' class="active" ' : ' ') .' ><a href="backend/config/index/'.$key.' " title="Cấu hình '.$val.' "> ' . $val . ' </a></li>';
				}
		echo '</ul>';
	?>
</section>
<section class="itq-form">
    <section class="main-panel main-panel-single">
        <form method="post" action="">
            <header>Thông tin chung</header>
            <section class="block">
			<?php if( isset($_config) && count($_config) ) { foreach($_config as $keyConfig => $valConfig){ ?>	
				<?php if($valConfig['type'] == 'text') {?>
				<label class="item">
                    <p class="label"><?php echo $valConfig['label'];?>:</p>
                    <input type="text" name="data[<?php echo $valConfig['keyword'];?>]" value="<?php echo common_valuepost(isset($_post[$valConfig['keyword']]) ? $_post[$valConfig['keyword']] : $valConfig['value_'.$_lang]) ; ?>" class="txtText" />
                </label>
				<?php  }  else if($valConfig['type'] == 'textarea') {?>
				<label class="item">
                    <p class="label"><?php echo $valConfig['label'];?>:</p>
                    <textarea name="data[<?php echo $valConfig['keyword'];?>]" class="mceEditor"><?php echo common_valuepost(isset($_post[$valConfig['keyword']]) ? $_post[$valConfig['keyword']] : $valConfig['value_'.$_lang]) ; ?></textarea>
				</label>
				
				<?php  }  else if($valConfig['type'] == 'editor' ) {?>
				<label class="item">
                    <p class="label"><?php echo $valConfig['label'];?>:</p>
                    <textarea name="data[<?php echo $valConfig['keyword'];?>]" class="mceEditor"><?php echo common_valuepost(isset($_post[$valConfig['keyword']]) ? $_post[$valConfig['keyword']] : $valConfig['value_'.$_lang]) ; ?></textarea>
				</label>
				
				<?php } else if($valConfig['type'] == 'radio') {?>
					<section class="checkbox-radio">
						<p class="label"><?php echo $valConfig['label'];?></p>
						<section class="group">	
							<label style="margin-bottom: 0px;"><input type="radio" name = "data[<?php echo $valConfig['keyword'];?>]" value="1" <?php echo(($valConfig['value_'.$_lang] == 1) ? 'checked = "checked" ' : ' ');?> /><span>Có</span></label>
							<label style="margin-bottom: 0px;"><input type="radio" name = "data[<?php echo $valConfig['keyword'];?>]" value="0" <?php echo(($valConfig['value_'.$_lang] == 0) ? 'checked = "checked" ' : ' ');?> /><span>Không</span></label>
						</section>
					</section>
				<?php }?>
			<?php  }  } ?>
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