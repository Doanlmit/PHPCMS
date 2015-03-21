<section class="itq-tab">
    <h1>Chủ đề</h1>
    <ul>
        <li class="active"><a href="backend/tag/index" title="Chủ đề">Chủ đề</a></li>
        <li><a href="backend/tag/addtag" title="Thêm chủ đề">Thêm chủ đề</a></li>
    </ul>
</section>
<section class="itq-wrapper">
    <section class="itq-view">
        <section class="advanced">
            <section class="search">
                <form method="get" action="backend/tag/index">
                    <input type="text" maxlength="100" placeholder="Nhập từ khóa tìm kiếm..." name="keyword" class="text" value="<?php echo isset($_keyword) ? htmlentities($_keyword):'';//show ra keyword gõ vào ô chủ đề?>"/>
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
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Tên chủ đề', 'field'=>'title', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Ngày tạo', 'field'=>'created', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Ngày sửa', 'field'=>'updated', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th>Người tạo</th>
                        <th>Người sửa</a></th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Hiển thị', 'field'=>'orders', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th>Thao tác</th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Mã', 'field'=>'id', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($_list) && count($_list)) { ?>
                    <?php foreach ($_list as $keyList => $valList) { ?>
                            <tr>
                                <td><?php echo (( $keyList + 1) + $_config['per_page'] * ($_page-1)); ?></td>
                                <td class="left"><?php echo $valList['title'];?></td>
                                <td><?php echo ($valList['created'] != '0000-00-00 00:00:00') ? gmdate('H: i d/m/y', strtotime($valList['created']) + 7 * 3600) : '-'; ?></td>
                                <td><?php echo ($valList['updated'] != '0000-00-00 00: 00: 00') ? gmdate('H: i d/m/y', strtotime($valList['updated']) + 7 * 3600) : '-'; // cach in ra dang full datetime// echo gmdate('m-d-Y H: i: s', time() + $valList['updated'] + 7 * 3600);  ?></td>
                                <td><?php $user = get_user($valList['userid_created'], 'username');echo isset($user['username']) ? $user['username'] : '-';?></td>
                                <td><?php $user = get_user($valList['userid_updated'], 'username');echo isset($user['username']) ? $user['username'] : '-';?></td>
                                <td><a href="backend/tag/set/publish/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title="trạng thái"><image src="public/template/backend/images/<?php echo $valList['publish'] == 1 ? 'check':'uncheck'?>.png" title="trạng thái"/></a></td>
                                <td><a href="backend/tag/deltag/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title = "xóa" onclick="return confirm('Bạn chắc chắn xóa?')"><img src="public/template/backend/images/delete.png" alt="delete" class="delete"/></a><a href="backend/tag/edittag/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title = "sửa"><img src="public/template/backend/images/edit.png" alt="check" class="edit"/></a></td>
                                <td class="last"><a href="#"><?php echo $valList['id']; ?></a></td>
                            </tr>
            <?php } ?>
        <?php }else{?>
                <td class="last" colspan="10"><p>Dữ liệu trống</p></td>
        <?php } ?>
     </tbody>
    </table>
</form><!--.form-->
</section><!--.itq-table-->
<?php echo (isset($pagination) && !empty($pagination)) ? '<section class = "pagination">' . $pagination . '.</section><!--.pagination-->' : ''; ?>
</section><!--.itq-view-->
</section><!--.itq-wraper-->