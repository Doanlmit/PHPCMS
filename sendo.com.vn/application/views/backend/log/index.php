<section class="itq-tab">
    <h1>Nhật ký hệ thống</h1>
    <ul>
        <li class="active"><a href="backend/log/index" title="log">Nhật ký</a></li>
    </ul>
</section>
<section class="itq-wrapper">
    <section class="itq-view">
        <section class="advanced">
            <section class="search">
                <form method="get" action="backend/log/index">
                    <input type="text" maxlength="100" placeholder="Nhập từ khóa tìm kiếm..." name="keyword" class="text" value="<?php echo isset($_keyword) ? htmlentities($_keyword):'';//show ra keyword gõ vào ô log?>"/>
                    <input type="hidden" name="sort_field" value="<?php echo $_sort['field'];?>"/>
                    <input type="hidden" name="sort_value" value="<?php echo $_sort['value'];?>"/>
                    <input type="submit" class="submit" value="Tìm kiếm"/>	
                </form>
            </section><!--search-->
        </section><!--.advanced-->
        ﻿<section class="table">
            <form method="post">        
            <table cellpadding="0" cellspacing="0" class="main">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'N.Ngữ', 'field'=>'lang', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Tên module', 'field'=>'module_name', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Tên sự kiện', 'field'=>'name_key', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th>Ghi chú</th>
                        <th>N.thực hiện</th>
                        <th>Thời gian</th>
                        <th>Thao tác</th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Mã', 'field'=>'id', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($_list) && count($_list)) { ?>
                    <?php foreach ($_list as $keyList => $valList) { ?>
                            <tr>
                                <td><?php echo (($keyList + 1) + $_config['per_page'] * ($_page-1)); ?></td>
                                <td><?php echo $valList['lang'];?></td>
                                <td><?php echo $valList['module_name'];?></td>
                                <td class="left"><?php echo $valList['name_key']?></td>
                                <td><?php echo $valList['note_action']?></td>
                                <td><?php $user = get_user($valList['userid_created'], 'username');echo isset($user['username']) ? $user['username'] : '-';?></td>
                                <td><?php echo ($valList['log_time'] != '0000-00-00 00:00:00') ? gmdate('H: i d/m/y', strtotime($valList['log_time']) + 7 * 3600) : '-'; ?></td>
                                <td><a href="backend/log/dellog/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title = "xóa" onclick="return confirm('Bạn chắc chắn xóa?')"><img src="public/template/backend/images/delete.png" alt="delete" class="delete"/></a></td>
                                <td><a href="#"><?php echo $valList['id'];?></a></td>
                            </tr>
            <?php } ?>
        <?php }else{?>
                <td class="last" colspan="9"><p>Dữ liệu trống</p></td>
        <?php } ?>
     </tbody>
    </table>
   <section class="display-none">
        <input type="submit" name="sort" value="Sắp xếp" id="btnSort"/> 
    </section>
</form><!--.form-->
</section><!--.itq-table-->
<?php echo (isset($pagination) && !empty($pagination)) ? '<section class = "pagination">' . $pagination . '.</section><!--.pagination-->' : ''; ?>
</section><!--.itq-view-->
</section><!--.itq-wraper-->