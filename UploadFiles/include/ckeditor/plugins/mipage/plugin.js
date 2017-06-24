// Register a plugin named "mipage".
(function()
{
    CKEDITOR.plugins.add( 'mipage',
    {
        init : function( editor )
        {
            // Register the command.
            editor.addCommand( 'mipage',{
                exec : function( editor )
                {
                    // Create the element that represents a print break.
                    // alert('mipageCmd!');
                    editor.insertHtml("#p#副标题#e#");
                }
            });
            // alert('mipage!');
            // Register the toolbar button.
            editor.ui.addButton( 'MyPage',
            {
                label : '插入分页符',
                command : 'mipage',
                icon: 'images/mipage.gif'
            });
            // alert(editor.name);
        },
        requires : [ 'fakeobjects' ]
    });
})();
