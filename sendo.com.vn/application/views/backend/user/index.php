<section class="itq-tab">
    <h1>Thành viên</h1>
    <ul>
        <li class="active"><a href="backend/user/index" title="Thành viên">Thành viên</a></li>
        <li><a href="backend/user/adduser" title="Thêm Thành viên">Thêm Thành viên</a></li>
    </ul>
</section>
<section class="itq-wrapper">
    <section class="itq-view">
        <section class="advanced">
            <section class="search">
                <input type="hidden" name="sort_field" value="<?php echo $_sort['field'];?>"/>
                <input type="hidden" name="sort_value" value="<?php echo $_sort['value'];?>"/>
                <form method="get" action="backend/user/index">
                    <?php 
                        echo form_dropdown('groupid'
                                            ,isset($_show['groupid']) ? $_show['groupid']:NULL
                                            ,common_valuepost(isset($_groupid) ? $_groupid:'')
                                            ,'class="cbSelect"'
                                           );
                    ?>
                <input type="name" maxlength="100" placeholder="Nhập từ khóa tìm kiếm..." name="keyword" class="text" value="<?php echo isset($_keyword) ? htmlentities($_keyword):'';?>"/>
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
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Tên thành viên', 'field'=>'username', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th>Bài viết</th>
                        <th>Nhóm</th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Email', 'field'=>'email', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Tên đầy đủ', 'field'=>'fullname', 'sort_field'=>$_sort['field'], 'sort_value'=>$_sort['value']));?></th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Ngày tạo', 'field'=>'created', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                        <th>Thao tác</th>
                        <th><?php echo get_link_sort(array('base_url' => $_config['base_url'], 'page'=>$_page, 'title'=>'Mã', 'field'=>'id', 'sort_field' => $_sort['field'], 'sort_value' => $_sort['value']));?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($_list) && count($_list)) { ?>
                    <?php foreach ($_list as $keyList => $valList) { ?>
                            <tr>
                                <td><?php echo (( $keyList + 1) + $_config['per_page'] * ($_page-1)); ?></td>
                                <td class="left"><a href="#"><?php echo $valList['username']; ?></a></td>
                                <td><?php 
                                        //Số bài viết mà các thành viên đã viết    
                                        echo get_count_post('article_item', 'id', array('id'=>$valList['groupid']));
                                    ?>
                                </td>
                                <td class="left"><?php 
                                        $group = get_category('user_group', 'id, title', array('id' => $valList['groupid'])); 
                                        echo isset($group['title']) ? $group['title'] : '';
                                    ?>
                                </td>
                                <td class="left"><a href="#"><?php echo $valList['email'];?></a></td>
                                <td class="center"><a href="#"><?php echo !empty($valList['fullname']) ? $valList['fullname'] : '--';?></a></td>
                                <td><?php echo ($valList['created'] != '0000-00-00 00:00:00') ? gmdate('H: i d/m/y', strtotime($valList['created']) + 7 * 3600) : '--'; ?></td>
                                <td><a href="backend/user/deluser/<?php echo $valList['id'];?>" title = "xóa" onclick="return confirm('Bạn chắc chắn xóa?')"><img src="public/template/backend/images/delete.png" alt="delete" class="delete"/></a><a href="backend/user/edituser/<?php echo $valList['id'];?>?continue=<?php echo base64_encode(common_fullurl());?>" title = "sửa"><img src="public/template/backend/images/edit.png" alt="check" class="edit"/></a></td>
                                <td class="last"><a href="#"><?php echo $valList['id']; ?></a></td>
                            </tr>
                        
            <?php } ?>
        <?php }else{?>
                <td class="last" colspan="7"><p>Dữ liệu trống</p></td>
        <?php } ?>
     </tbody>
    </table>
   </form><!--.form-->
</section><!--.itq-table-->
<?php echo (isset($pagination) && !empty($pagination)) ? '<section class = "pagination">' . $pagination . '.</section><!--.pagination-->' : ''; ?>
</section><!--.itq-view-->
</section><!--.itq-wraper-->