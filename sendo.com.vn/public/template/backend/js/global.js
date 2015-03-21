  $(window).load(function(){
	if($('section.itq-form .side-panel').height() > $('section.itq-form .main-panel').height())
		$('section.itq-form').height($('section.itq-form .side-panel').height() + 20);
    });
    $(document).ready(function(){ });
  $('#txtTimestart, #txtTimesend, #txtTimer').datetimepicker({
        format: 'H:m:s d/m/Y',
    });
    //Phần đầu Clip 18 Check all
    $(window).load(function(){
        var _this = '';
        var _temp = '';
    //Check id
    $('#check-all').click(function(){
        if($(this).prop('checked')){
            $('.check-all').prop('checked', true).parent().parent().find('td').addClass('select');
        }else{
            $('.check-all').prop('checked', false).parent().parent().find('td').removeClass('select');
        }
    });
    //Check class
    $('.check-all').click(function(){
        if($(this).prop('checked') == false){
            $(this).parent().parent().find('td').removeClass('select');
            $('#check-all').prop('checked', false);
        }else{
            $(this).parent().parent().find('td').addClass('select');
        }
        if($('.check-all:checked').length == $('.check-all').length){
            $('#check-all').prop('check',false); 
        }
    });
    
    });
    
    /***********Begin Tags suggest*********/
    $('#tags-suggest').click(function(){
        if($('#tagspicker-suggest').is(':hidden')){
            $('#tagspicker-suggest').show();
            $('#tagspicker-suggest').html('<p><img src="http://www.ajaxload.info/images/exemples/2.gif"/>Đang tải dữ liệu... </p>')
            $.post('backend/tag/suggest', function(data){
                $('#tagspicker-suggest').width(568);
                $('#tagspicker-suggest').html(data);
            });
        }
        else{
            $('#tagspicker-suggest').width(168);
            $('#tagspicker-suggest').hide();
            $('#tagspicker-suggest').html('');  
        }
        return false;
    });
    
    $('#tagspicker-suggest').on('click', '.title a', function(){
        _this = $(this);
        $('#tagspicker-suggest').width('168');
        $('#tagspicker-suggest').html('<p><img src="http://www.ajaxload.info/images/exemples/2.gif"/>Đang tải dữ liệu... </p>')
        $.post(_this.attr('href'), function(data){
                $('#tagspicker-suggest').width(668);
                $('#tagspicker-suggest').html(data);
            });
        return false;
    });
    $('#tagspicker-suggest').on('click', '.suggest a', function(){
        _this = $(this);
        _temp = $('#txtTags').val();
        $('#txtTags').val('Đang tải dữ liệu ... ');
        $.post('backend/tag/insert',{item:_this.attr('title'), list: _temp} ,function(data){
                $('#txtTags').val(data);
            });
        return false;
    });
    
     /***********End Tags suggest*********/
     
    /************Mouse enable when click to input Chu de Clip-20**********/ 
    $(document).mouseup(function(e){
        var container = $('#tagspicker-suggest');
        if(!container.is(e.target) && container.has(e.target).length === 0){
            $('#tagspicker-suggest').width(168);
            $('#tagspicker-suggest').html('').hide();
        }
    });
     /***********Clip 17 - Khi xóa em sẽ hỏi anh có xóa hay không? *********/
    function delete_all(){
        if(confirm('Bạn có chắc chắn xóa!')){
             document.getElementById('btnDel').click(); return false;
        }
    }    