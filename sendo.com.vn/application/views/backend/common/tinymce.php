<script type="text/javascript" src="public/template/backend/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js"></script >
<script type="text/javascript">
tinyMCE.init({
                // General options /*Clip 13*/
                mode : "textareas",
                theme : "advanced",
                editor_selector : "mceEditor",//sử dụng với class được gọi trong textarea
                plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
                file_browser_callback: 'openKCFinder',
                // Theme options
                theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_statusbar_location : "bottom",
                theme_advanced_resizing : true,
                
                
                // Example content CSS (should be your site CSS)
                content_css : "css/content.css",

                // Drop lists for link/image/media/template dialogs
                template_external_list_url : "lists/template_list.js",
                external_link_list_url : "lists/link_list.js",
                external_image_list_url : "lists/image_list.js",
                media_external_list_url : "lists/media_list.js",

                // Style formats
                style_formats : [
                        {title : 'Bold text', inline : 'b'},
                        {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
                        {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
                        {title : 'Example 1', inline : 'span', classes : 'example1'},
                        {title : 'Example 2', inline : 'span', classes : 'example2'},
                        {title : 'Table styles'},
                        {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
                ],

                formats : {
                        alignleft : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'left'},
                        aligncenter : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'center'},
                        alignright : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'right'},
                        alignfull : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'full'},
                        bold : {inline : 'span', 'classes' : 'bold'},
                        italic : {inline : 'span', 'classes' : 'italic'},
                        underline : {inline : 'span', 'classes' : 'underline', exact : true},
                        strikethrough : {inline : 'del'}
                },

                // Replace values for the template plugin
                template_replace_values : {
                        username : "Some User",
                        staffid : "991234"
                }
        });

function openKCFinder(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
        file: 'public/template/backend/plugins/kcfinder/browse.php?opener=tinymce&lang=vi&type=' + type,
        title: 'KCFinder',
        width: 700,
        height: 500,
        resizable: true,
        inline: true,
        close_previous: false,
        popup_css: false
    }, {
        window: win,
        input: field_name
    });
    return false;
}
function browserKCFinder(field,type ){
        window.KCFinder =  {
        callBack:function(url){
            document.getElementById(field).value = url;
            window.KCFinder = null;
        }
    };
        window.open('public/template/backend/plugins/kcfinder/browse.php?type='+type+'&lang=vi', 'kcfinder_textbox',
            'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
            'resizable=1, scrollbars=0, width=800, height=600'
        );
    }
</script>
