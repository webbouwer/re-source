/* Startpage template Javascript file */
jQuery(function($) {

	$(document).ready(function(){

        var objlist = []; // all posts
        var tagfilter = [];

       // var catfilter = [];

            // display posts
            var markupHTMLContent = function(result){
                $('#leftmenucontainer .contentbox, #maincontentcontainer .contentbox, #rightcontentcontainer .contentbox').html('');
                var htmllist = '', oc = 0;
                $.each( result, function(idx,obj){

                        objlist[obj.id] = obj;

                        var html = '',
                        objfilterclasses = '',
                        display_tags = gethtmlListTags( obj.tags ),
                        display_cats = gethtmlListCats( obj.cats );

                        $(obj.tags).each(function( x , tag ){
                            objfilterclasses += ' '+tag;
                        });
                        var itemtype = 0;
                        $(obj.cats).each(function( x , cat ){
                            if( cat == 'uncategorized' ){
                                itemtype = 1;
                                 objfilterclasses += ' menubutton';
                            }
                            if( cat == 'examples-1' ){
                                itemtype = 2;
                                 objfilterclasses += ' overviewcontent';
                            }
                            objfilterclasses += ' '+cat;
                        });
                        var catreverse = obj.cats.reverse();
                        if(oc = 0){
                            objfilterclasses += ' base';
                        }

                        html += '<div id="post-'+obj.id+'" data-id="'+obj.id+'" class="item '+objfilterclasses+'" ';
                        html += 'data-author="'+obj.author+'" data-timestamp="'+obj.timestamp+'" data-category="'+catreverse[0]+'" ';
                        html += 'data-tags="'+obj.tags+'" data-cats="'+obj.cats+'" data-matchweight="0">';
                        html += '<div class="matchweight moderate">0</div>';
                        html += '<div class="itemcontent">';
                        html += '<div class="intro"><div class="title"><h3>'+obj.title+'</h3><div class="author">'+obj.author+'</div></div>';
                        if(obj.image && obj.image != ''){
                            html += '<div class="coverimage">'+obj.image+'</div>';
                        }else{
                            html += '<div class="mediaplaceholder"><h3>'+obj.title+'</h3>Media placeholder</div>';
                        } //html += '<div class="excerpt">'+obj.excerpt+'</div>';
                        html += '<div class="itemcatbox">'+display_cats+'</div><div class="itemtagbox">'+display_tags+'</div></div>';
                        html += '<div class="main"><div class="textbox"></div></div>'; //'+obj.content+'
                        html += '</div>';
                        html += '<div class="infotoggle button"><span>+</span></div>';
                        html += '</div>';
                        oc++;

                        htmllist += html;

                        if( itemtype == 1 ){
                            $('#leftmenucontainer .contentbox').append( html );
                        }else if( itemtype == 2 ){
                            $('#maincontentcontainer .contentbox').append( html );
                        }else{
                            $('#rightcontentcontainer .contentbox').append( html );
                        }
                });

            };

            // display clickable tags
            var gethtmlListTags = function( itemtags ){
                var tags = JSON.parse(site_data['tagdata']); //console.log(tags);
                var html = '';
                for(i=0;i<tags.length;i++){
                    for(t=0;t<itemtags.length;t++){
                        if( tags[i]['name'] == itemtags[t] ){
                            html += '<a href="#tags='+tags[i]['slug']+'" class="tagbutton '+tags[i]['slug']+'" data-tag="'+tags[i]['slug']+'">'+tags[i]['name']+'</a> ';
                        }
                    }
                }
                return html;
            };


            // display clickable categories
            var gethtmlListCats = function( itemcats ){
                var cats = JSON.parse(site_data['catdata']);
                //console.log(cats);
                var html = '';
                for(i=0;i<cats.length;i++){

                    for(t=0;t<itemcats.length;t++){
                        if( cats[i]['slug'] == itemcats[t] ){
                            html += '<a href="#cats='+cats[i]['slug']+'" class="catbutton '+cats[i]['slug']+'" data-cats="'+cats[i]['slug']+'">'+cats[i]['cat_name']+'</a> ';
                        }
                    }
                }
                return html;
            };

            // display tag menu
            var markupHTMLTagMenu = function( tags ){
                var html = '';
                for(i=0;i<tags.length;i++){
                    html += '<a href="#tags='+tags[i]['slug']+'" class="tagbutton '+tags[i]['slug']+'" data-tag="'+tags[i]['slug']+'">'+tags[i]['name']+'</a>';
                }
                $('#rightmenucontainer .contentbox').html( html );
            };

            // display selected clickable tags
            var sethtmlSelectedTags = function( el ){
                tagfilter = [];
                el.toggleClass('selected');
                if( $('#rightmenucontainer #tagmenu').length < 1 ){
                    $('#rightmenucontainer .contentbox').prepend('<div id="tagmenu"></div>');
                }
                $('#tagmenu').html('');
                $('#rightmenucontainer .tagbutton.selected').each( function(idx,obj){
                    $('#tagmenu').append( $(obj).clone() );
                    tagfilter.push( $(obj).data('tag') );
                });
                console.log(tagfilter);
            }

            // set Data
            if( site_data['postdata'].length > 0 ){
                markupHTMLContent( JSON.parse(site_data['postdata']) );
            }
            if( site_data['tagdata'].length > 0 ){
                markupHTMLTagMenu( JSON.parse(site_data['tagdata']) );
            }

            // click event left menubutton
            var setLeftContent = function( el ){
                var content = el.clone();
                $('#leftcontentcontainer .contentbox').html( content.removeClass('menubutton') );
            }



            // toggle left menu
            $('#leftmenucontainer .togglebox').on( 'click', function(){
                $('#infocontainer').slideUp(200);
                $('body').toggleClass('articlemenu');
            });
            // toggle right menu
            $('#rightmenuplaceholder .togglebox').on( 'click', function(){
                $('#infocontainer').slideUp(200);
                $('body').toggleClass('filtermenu');
            });

            $('#rightmenucontainer .tagbutton').on( 'click', function( event ){
                if(event.preventDefault){
                    event.preventDefault();
                }else{
                    event.returnValue = false;
                }

                // contentfilter
                sethtmlSelectedTags( $(this) );

                // display
                $('#infocontainer').slideUp(200);
                $('body').removeClass('overview');
                $('body').removeClass('theory');
                $('body').addClass('practice');
            });

            // button right menu (tag deselect button)
            $('body').on('click', '#tagmenu .tagbutton', function( event ){
                if(event.preventDefault){
                    event.preventDefault();
                }else{
                    event.returnValue = false;
                }

                // contentfilter
                var el = $('#rightmenucontainer .'+ $(this).data('tag') );
                sethtmlSelectedTags( el );

                // display
                $('#infocontainer').slideUp(200);
                $('body').removeClass('overview');
                $('body').removeClass('theory');
                $('body').addClass('practice');
            });


            // button left menu
            $('#leftmenucontainer .menubutton').on( 'click', function(){
                $('#infocontainer').slideUp(200);
                $('body').removeClass( 'overview' );
                $('body').removeClass( 'practice' );
                $('body').addClass('theory');
                setLeftContent( $(this) );
            });

            // toggle slide info content
            $('#topbar .leftside .menubutton').on( 'click', function( event ){
                if(event.preventDefault){
                    event.preventDefault();
                }else{
                    event.returnValue = false;
                }
                $('#infocontainer').slideToggle(300);
                $('#infocontainer').toggleClass( 'active' );
            });

            // toggle slide main content
            $('.switchbutton span').on( 'click', function( event ){
                $('#infocontainer').slideUp(200);
                if( $('body').hasClass('overview') ){

                    $('body').removeClass( 'overview' );
                    $('body').removeClass( 'filtermenu' );

                    $('body').addClass( 'articlemenu' );
                    $('body').addClass('theory');

                }else if( $('body').hasClass('practice') ){

                    $('body').removeClass( 'practice' );
                    $('body').removeClass( 'filtermenu' );

                    $('body').addClass( 'articlemenu' );
                    $('body').addClass('theory');

                }else if( $('body').hasClass('theory') ){

                    $('body').removeClass( 'theory' );
                    $('body').removeClass( 'overview' );

                    $('body').removeClass( 'articlemenu' );
                    $('body').addClass('practice');
                }
            });

            // button home start content
            $('#topbar .leftside .custom-logo-link').on( 'click', function( event ){
                if(event.preventDefault){
                    event.preventDefault();
                }else{
                    event.returnValue = false;
                }
                $('#infocontainer').slideUp(200);
                $('body').removeClass( 'theory' );
                $('body').removeClass( 'practice' );
                $('body').removeClass( 'articlemenu' );
                $('body').removeClass( 'filtermenu' );
                $('body').addClass('overview');
            });

            // Init
            // $('body').addClass('theory');,$('body').addClass('practice'),$('body').addClass('articlemenu'),$('body').addClass('filtermenu');
            $('body').addClass('overview');

	});

    $(window).load(function() {


    });

    $(document).ajaxStart(function() {
    });

    $(document).ajaxComplete(function() { // http://api.jquery.com/ajaxstop/

    });

});
