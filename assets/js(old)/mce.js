'use strict';

jQuery(document).ready(function ($) {

    (function () {

        //This is referencing to your plugin array in your my_plugin.php
        tinymce.PluginManager.add('example_plugin_array', function (editor, url) {

            // This will reference a button function we will now create
            // in the my_plugin.php file.
            editor.addButton('my_plugin_button', {
                text: 'Add Button',
                icon: false,
                onclick: function onclick() {
                    editor.insertContent("[bp_button type='primary' align='center' label='Learn More' link='']");
                }
            });

            //  editor.on( 'BeforeSetContent', function( e ) {
            //    console.log('BeforeSetContent');
            //    e.content = setContent(e.content);
            //      // 'wpview' handles the gallery shortcode when present
            //      // if ( ! editor.plugins.wpview || typeof wp === 'undefined' || ! wp.mce ) {
            //      //          event.content = replaceGalleryShortcodes( event.content );
            //      //    }
            // });

            //  editor.on('click',function(e) {
            //     var cls  = e.target.className.indexOf('wp-bs3_panel');
            //     // if ( e.target.nodeName == 'IMG' && e.target.className.indexOf('wp-bs3_panel') > -1 ) {
            //     //     var title = e.target.attributes['data-sh-attr'].value;
            //     //     title = window.decodeURIComponent(title);
            //     //     console.log(title);
            //     //     var content = e.target.attributes['data-sh-content'].value;
            //     //     editor.execCommand('bs3_panel_popup','',{
            //     //         header : getAttr(title,'header'),
            //     //         footer : getAttr(title,'footer'),
            //     //         type   : getAttr(title,'type'),
            //     //         content: content
            //     //     });
            //     // }
            // });
        });
    })();

    //  function setContent(content) {
    //    return content.replace( /\[gallery([^\]]*)\]/g, function( match ) {
    //       return html( 'wp-gallery', match );
    //     });
    //   }
    //
    // function restoreMediaShortcodes( content ) {
    //   function getAttr( str, name ) {
    //           name = new RegExp( name + '=\"([^\"]+)\"' ).exec( str );
    //           return name ? window.decodeURIComponent( name[1] ) : '';
    //   }
    //
    //   return content.replace( /(?:<p(?: [^>]+)?>)*(<img [^>]+>)(?:<\/p>)*/g, function( match, image ) {
    //           var data = getAttr( image, 'data-wp-media' );
    //
    //           if ( data ) {
    //                   return '<p>' + data + '</p>';
    //           }
    //
    //           return match;
    //   });
    // }
}); // End jQuery