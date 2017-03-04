(function() {
    tinymce.create('tinymce.plugins.DTPortfolio', {

        init : function(ed, url) {

            ed.addButton('showrecent', {
                title : 'Add Folio Shortcode',
                type: 'menubutton',
                icon : 'icon dashicons-star-filled',                
                menu: [
                        {
                            text: 'Build Button Shortcode',
                            value: '',
                            onclick : function() {
                                // triggers the thickbox
                                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                                W = W + 20;
                                H = H - 140;
                                tb_show( 'Button Shortcode Generator', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=dtportfolio-form' );
                            },
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
        var form = jQuery('<div id="dtportfolio-form"><table id="dtportfolio-table" class="form-table">\
            <tr>\
                <th><label for="dtportfolio-portfoliotype">Portfolio Type</label><br><small>Select The Layout For Your Portfolio</small></th>\
                <td><label class="isotopelabel" for="isotope"></label>\
                <span class="labeltext"><input value="isotope" class="notpagedselector" name="portfoliotype" type="radio" checked="checked"> Isotope</span>\
                <label class="filtrifylabel" for="filtrify"></label>\
                <span class="labeltext"><input value="filtrify" class="notpagedselector" name="portfoliotype" type="radio"> Filtrify</span>\
                <br><label class="pagedlabel" for="paged"></label>\
                <span class="labeltext"><input name="portfoliotype" id="pagedselector" type="radio" value="paged"> Paged </span>\
                <label class="gridlabel" for="grid"></label>\
                <span class="labeltext"><input name="portfoliotype" class="notpagedselector" type="radio" value="grid"> Grid</span>\
                <br><label class="masonrylabel" for="masonry"></label>\
                <span class="labeltext"><input name="portfoliotype" class="notpagedselector" type="radio" value="masonry"> Masonry</span>\
                <label class="masonryisotopelabel" for="masonryisotope"></label>\
                <span class="labeltext"><input name="portfoliotype" class="notpagedselector" type="radio" value="masonryisotope"> Masonry + Isotope</span>\
                </td>\
            </tr>\
            <tr>\
                <th><label for="dtportfolio-columns">Number Of Columns</label><br><small>Select The Number Of Columns you wish to use.</small></th>\
                <td><select name="columns" id="dtportfolio-columns">\
                    <option value="dt_portfolio_grid_12">One Column</option>\
                    <option value="dt_portfolio_grid_6">Two Columns</option>\
                    <option value="dt_portfolio_grid_4">Three Columns</option>\
                    <option value="dt_portfolio_grid_3">Four Columns</option>\
                </select><br />\
                </td>\
            </tr>\
            <tr>\
                <th><label for="dtportfolio-showtitle">Project Titles</label><br><small>Display/Hide Titles</small></th>\
                <td><select name="showtitle" id="dtportfolio-showtitle">\
                    <option value="yes">Show Item Titles</option>\
                    <option value="no">Hide Item Titles</option>\
                </select></td>\
            </tr>\
            <tr>\
                <th><label for="dtportfolio-showexcerpt">Project Excerpt</label><br><small>Display/Hide Excerpt</small></th>\
                <td><select name="showexcerpt" id="dtportfolio-showexcerpt">\
                    <option value="yes">Show Item Excerpt</option>\
                    <option value="no">Hide Item Excerpt</option>\
                </select></td>\
            </tr>\
            <tr>\
                <th><label for="dtportfolio-imgheight">Image Height</label><br><small>Specify Image Height in PX - For Example 180, NOT 180px.</small></th>\
                <td><input type="text" name="imgheight" id="dtportfolio-imgheight" value="180" /><br />\
            </tr>\
            <tr>\
                <th><label for="dtportfolio-imgwidth">Image Width</label><br><small>Specify Image Width in PX - For Example 260, NOT 260px.</small></th>\
                <td><input type="text" name="imgwidth" id="dtportfolio-imgwidth" value="260" /><br />\
            </tr>\
            <tr>\
                <th><label for="dtportfolio-showsocial">Social Icons</label><br><small>Display/Hide Socials Icons</small></th>\
                <td><select name="showsocial" id="dtportfolio-showsocial">\
                    <option value="yes">Show Share Buttons</option>\
                    <option value="no">Hide Share Buttons</option>\
                </select></td>\
            </tr>\
            <tr>\
                <th><label for="dtportfolio-showlikes">Show Like Box?</label><br><small>Display/Hide Like Button</small></th>\
                <td><select name="showlikes" id="dtportfolio-showlikes">\
                    <option value="yes">Show Like Box</option>\
                    <option value="no">Hide Like Box</option>\
                </select></td>\
            </tr>\
            <tr>\
                <th><label for="dtportfolio-tagged">Show Tagged Projects Only</label><br><small>Specify a Portfolio Tag slug to display - ONE TAG ONLY</small></th>\
                <td><input type="text" name="tagged" id="dtportfolio-tagged" value="" /><br />\
            </tr>\
            <tr class="pagedinput">\
                <th><label for="dtportfolio-perpaged">Posts Per Page (Paged Only)</label><br><small>Specify number of posts per page.</small></th>\
                <td><input type="text" name="perpaged" id="dtportfolio-perpaged" value="" /><br />\
            </tr>\
        </table>\
        <p class="submit dtsubmit">\
            <input type="button" id="dtportfolio-submit" class="button-primary" value="Insert Portfolio" name="submit" />\
        </p>\
        </div>');
        
        var table = form.find('table');
        form.appendTo('body').hide();
        
        // handles the click event of the submit button
        form.find('#dtportfolio-submit').click(function(){
            var options = {
                'columns'    : '',
                'perpaged'    : '',
                'showtitle'    : '',
                'showexcerpt'    : '',
                'imgwidth'    : '',
                'imgheight'    : '',
                'showlikes'    : '',
                'showsocial'    : '',
                'tagged'    : '',
                };
            var shortcode = '[dt-portfolio';
            var value2 = table.find('input[type="radio"]:checked').val();

            shortcode += ' portfoliotype="' + value2 + '"';
            
            for( var index in options) {
                var value = table.find('#dtportfolio-' + index).val();                
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
