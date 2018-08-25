/* Startpage template Javascript file */
jQuery(function($) {

	$(document).ready(function(){

            var markupHTMLContent = function(result){

                $('#leftmenucontainer .contentbox, #maincontentcontainer .contentbox, #rightcontentcontainer .contentbox').html('');

                var htmllist = '', oc = 0;
                $.each( result, function(idx,obj){

                        var html = '';
                        var display_tags = gethtmlListTags( obj.tags );
                        var display_cats = gethtmlListCats( obj.cats );

                        var objfilterclasses = '';
                        $(obj.tags).each(function( x , tag ){
                            objfilterclasses += ' '+tag;
                        });
                        var itemsort = 0;
                        $(obj.cats).each(function( x , cat ){
                            if( cat == 'uncategorized' ){
                                itemsort = 1;
                                 objfilterclasses += ' menubutton';
                            }
                            if( cat == 'examples-1' ){
                                itemsort = 2;
                                 objfilterclasses += ' overviewcontent';
                            }
                            objfilterclasses += ' '+cat;
                        });
                        var catreverse = obj.cats.reverse();
                        if(oc = 0){
                            objfilterclasses += ' base';
                        }

                        html += '<div id="post-'+obj.id+'" data-id="'+obj.id+'" ';
                        html += 'class="item '+objfilterclasses+'" ';
                        html += 'data-author="'+obj.author+'" data-timestamp="'+obj.timestamp+'" ';
                        html += 'data-tags="'+obj.tags+'" data-cats="'+obj.cats+'" data-category="'+catreverse[0]+'" data-matchweight="0">';

                        html += '<div class="matchweight moderate">0</div>';

                        html += '<div class="itemcontent">';

                        html += '<div class="intro">';
                        html += '<div class="title"><h3>'+obj.title+'</h3><div class="author">'+obj.author+'</div></div>';
                        if(obj.image && obj.image != ''){
                            html += '<div class="coverimage">'+obj.image+'</div>';
                        }else{
                            html += '<div class="mediaplaceholder"><h3>'+obj.title+'</h3>Media placeholder</div>';
                        }
                        //html += '<div class="excerpt">'+obj.excerpt+'</div>';
                        html += '<div class="itemcatbox">'+display_cats+'</div>';
                        html += '<div class="itemtagbox">'+display_tags+'</div>';

                        html += '</div>';

                        html += '<div class="main"><div class="textbox"></div></div>'; //'+obj.content+'

                        html += '</div>';
                        html += '<div class="infotoggle button"><span>+</span></div>';
                        html += '</div>';
                        oc++;

                        htmllist += html;

                        if( itemsort == 1 ){
                            $('#leftmenucontainer .contentbox').append( html );
                        }else if( itemsort == 2 ){
                            $('#maincontentcontainer .contentbox').append( html );
                        }else{
                            $('#rightcontentcontainer .contentbox').append( html );
                        }
                });

            };

            // display clickable tags
            var gethtmlListTags = function( itemtags ){
                var tags = JSON.parse(site_data['tagdata']);
                //console.log(tags);
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


            if( site_data['postdata'].length > 0 ){
                markupHTMLContent( JSON.parse(site_data['postdata']) );
            }

            // display tag menu
            var markupHTMLTagMenu = function( tags ){
                var html = '';
                for(i=0;i<tags.length;i++){
                    html += '<a href="#tags='+tags[i]['slug']+'" class="tagbutton '+tags[i]['slug']+'" data-tag="'+tags[i]['slug']+'">'+tags[i]['name']+'</a> ';
                }
                $('#rightmenucontainer .contentbox').html( html );
            };
            if( site_data['tagdata'].length > 0 ){
                markupHTMLTagMenu( JSON.parse(site_data['tagdata']) );
            }

            // click event left menubutton
            var setLeftContent = function( el ){
                var content = el.clone();
                $('#leftcontentcontainer .contentbox').html( content.removeClass('menubutton') );
            }



            $('#leftmenucontainer .togglebox').on( 'click', function(){
                $('#infocontainer').slideUp(200);
                $('body').toggleClass('articlemenu');
            });
            $('#rightmenuplaceholder .togglebox').on( 'click', function(){
                $('#infocontainer').slideUp(200);
                $('body').toggleClass('filtermenu');
            });

            $('#rightmenucontainer .tagbutton').on( 'click', function(){
                $('#infocontainer').slideUp(200);
                $('body').removeClass('overview');
                $('body').removeClass('theory');
                $('body').addClass('practice');
            });
            $('#leftmenucontainer .menubutton').on( 'click', function(){
                $('#infocontainer').slideUp(200);
                $('body').removeClass( 'overview' );
                $('body').removeClass( 'practice' );
                $('body').addClass('theory');
                setLeftContent( $(this) );
            });


            $('#topbar .leftside .menubutton').on( 'click', function( event ){
                if(event.preventDefault){
                    event.preventDefault();
                }else{
                    event.returnValue = false;
                }
                $('#infocontainer').slideToggle(300);
                $('#infocontainer').toggleClass( 'active' );
            });

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

                    $('body').addClass('theory');

                }else if( $('body').hasClass('theory') ){

                    $('body').removeClass( 'theory' );
                    $('body').removeClass( 'overview' );

                    $('body').removeClass( 'articlemenu' );
                    $('body').addClass('practice');
                }
            });

            $('body').addClass('overview');
            //$('body').addClass('theory');
            //$('body').addClass('practice');

            //$('body').addClass('articlemenu');
            //$('body').addClass('filtermenu');
	});

    $(window).load(function() {
    });

    $(document).ajaxStart(function() {
    });

    $(document).ajaxComplete(function() { // http://api.jquery.com/ajaxstop/

    });

});
