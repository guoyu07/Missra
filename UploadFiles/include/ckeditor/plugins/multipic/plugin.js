// Register a plugin named "mipage".
(function()
{
    CKEDITOR.plugins.add( 'multipic',
    {
        init : function( editor )
        {
            // Register the command.
            editor.addCommand( 'multipic',{
                exec : function( editor )
                {
                    // Create the element that represents a print break.
                    // alert('mipageCmd!');
					var mpic = document.getElementById("mPic");
					if(mpic != null && typeof mpic != 'undefined' )
					{
						if(mpic.style.display=='none')
						{
							mpic.style.display='block';
						} else {
							mpic.style.display='none';
						}
					}else {
						alert('本编辑器不支持多图发布功能!');
					}
                }
            });
            // alert('mipage!');
            // Register the toolbar button.
            editor.ui.addButton( 'MultiPic',
            {
                label : '多图发布',
                command : 'multipic',
                icon: 'images/multipic.gif'
            });
            // alert(editor.name);
        },
        requires : [ 'fakeobjects' ]
    });
})();
