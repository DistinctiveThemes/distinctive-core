(function() {
    tinymce.create('tinymce.plugins.DTPortfolio', {

        init : function(ed, url) {

            ed.addButton('open_builder', {
                title : 'Add A Custom Shortcode',
                type: 'menubutton',
                icon : 'icon dt-core-icon',                
                menu: [
                        {
                            text: 'Build Button Shortcode',
                            value: '',
                            onclick : function() {
                                // triggers the thickbox
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W + 20;
                                H = H - 140;
                                tb_show( 'Button Shortcode Generator', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=distinctive-shortcode-form' );
                            },
                        },
                        {
                            text: 'Lead Text',
                            onclick: function() {
                                var shortcode = '[distinctive-lead-text';
                                shortcode += '][/distinctive-lead-text]';
                                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
                            }
                        },
                    ]
            });
        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                    longname : 'Distinctive Core Shortcode Buttons',
                    author : 'Distinctive Themes',
                    authorurl : 'http://www.distinctivethemes.com',
                    infourl : 'http://www.distinctivethemes.com',
                    version : "0.1"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('distinctivecore_shortcode', tinymce.plugins.DTPortfolio);


    // executes this when the DOM is ready
    jQuery(function(){
        // creates a form to be displayed everytime the button is clicked
        // you should achieve this using AJAX instead of direct html code like this
        var form = jQuery('<div id="distinctive-shortcode-form"><table id="distinctive-shortcode-table" class="form-table">\
            <tr>\
                <th><label for="distinctive-shortcode-button_style">Button Style</label><br><small>Select style you wish to use.</small></th>\
                <td><select name="button_style" id="distinctive-shortcode-button_style">\
                    <option value="btn">Regular Button</option>\
                    <option value="btn-dark">Dark Button</option>\
                    <option value="btn-white">White Button</option>\
                    <option value="btn-outlined">Button Outlined</option>\
                    <option value="btn-outlined-white">Button White Outlined</option>\
                </select><br />\
                </td>\
            </tr>\
            <tr>\
                <th><label for="distinctive-shortcode-button_label">Button Label</label><br><small>Specify Button Label.</small></th>\
                <td><input type="text" name="button_label" id="distinctive-shortcode-button_label" value="Click Here" /><br />\
            </tr>\
            <tr>\
                <th><label for="distinctive-shortcode-button_url">Button URL</label><br><small>Specify Button URL.</small></th>\
                <td><input type="text" name="button_url" id="distinctive-shortcode-button_url" value="#" /><br />\
            </tr>\
        </table>\
        <p class="submit dtsubmit">\
            <input type="button" id="distinctive-shortcode-submit" class="button_primary button-primary" value="Insert Portfolio" name="submit" />\
        </p>\
        </div>');
        
        var table = form.find('table');
        form.appendTo('body').hide();
        
        // handles the click event of the submit button
        form.find('#distinctive-shortcode-submit').click(function(){
            var options = {
                'button_style'    : '',
                'button_label'    : '',
                'button_url'    : '',
                };
            var shortcode = '[distinctive-button';
            var value2 = table.find('input[type="radio"]:checked').val();

            //shortcode += ' button_style="' + value2 + '"';
            
            for( var index in options) {
                var value = table.find('#distinctive-shortcode-' + index).val();                
                if ( value !== options[index] )
                    shortcode += ' ' + index + '="' + value + '"';
            }            
            
            shortcode += ']';
            
            // inserts the shortcode into the active editor
            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
            
            // closes Thickbox
            tb_remove();
        });
    
    });


})();
