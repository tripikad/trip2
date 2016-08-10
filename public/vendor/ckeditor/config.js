/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
    //config.extraPlugins = 'colorbutton,justify';
	// The toolbar groups arrangement, optimized for two toolbar rows.
    config.allowedContent = true;
    config.removeFormatAttributes = '';
    config.height = 600;

	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

    config.toolbar = [
        { name: 'tools', items: [ 'Bold', 'Italic', 'BulletedList', 'Link', 'Source' ]},

    /*
        { name: 'clipborad', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ]},
        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ]},
        { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ]},
        { name: 'tools', items: [ 'Maximize' ]},
        { name: 'document', items: [ 'Source' ]},
        '/',
        { name: 'colors', items: [ 'TextColor' ]},
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat', '-', 'Subscript', 'Superscript' ]},
        { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyBlock', 'JustifyLeft', 'JustifyCenter', 'JustifyRight' ]},
        { name: 'styles', items: [ 'Format' ]}
    */
    ];

	config.removePlugins = 'uploadimage,backup,stat';
	config.resize_enabled = false;
	config.format_tags = 'p;h3;h4;h5;h6;pre;address;div';
    config.contentsCss = '/css/main.css';
    config.colorButton_enableMore = false;
    config.colorButton_colors = 'f7ba00,d67d00,78cc5c,288f18,ed6262,cb4949,b13636,8b84d7,5147c0,4ac9e3,0087ae,ff9a3e,d94d00,111111,222222,707477,444444,999999';
};
