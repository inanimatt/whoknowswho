/// <reference path="jquery-1.3.2-vsdoc2.js" />
/*----------------------------------------
Author:     	Nick Lowman
Author URI: 	http://www.tui.co.uk/
Project:		Who Knows Who	
Notes: 			
----------------------------------------*/


/* IE has an issue with functions involving opacity changes in jQuery
* so these override fadeIn, faceOut and FadeTo
----------------------------------------*/
$(function() {
    $.ajaxSetup({
        cache: false
    });

    jQuery.fn.fadeIn = function(speed, callback) {
        return this.animate({ opacity: 'show' }, speed, function() {
            if (jQuery.browser.msie)
                this.style.removeAttribute('filter');
            if (jQuery.isFunction(callback))
                callback();
        });
    };

    jQuery.fn.fadeOut = function(speed, callback) {
        return this.animate({ opacity: 'hide' }, speed, function() {
            if (jQuery.browser.msie)
                this.style.removeAttribute('filter');
            if (jQuery.isFunction(callback))
                callback();
        });
    };

    jQuery.fn.fadeTo = function(speed, to, callback) {
        return this.animate({ opacity: to }, speed, function() {
            if (to == 1 && jQuery.browser.msie)
                this.style.removeAttribute('filter');
            if (jQuery.isFunction(callback))
                callback();
        });
    };
});


/*
$(function() {
    //var $imgCover = $('<div class="imgcover">');
    $('.block-028 div.image')
    .add('.block-029 div.image')
        .before('<div class="imgcover">');

    $('div.image').mouseenter(function() {
        var $cover = $(this).siblings('.imgcover');
        $cover.show();
        $cover.fadeTo('normal', 1, function() {
            $cover.fadeTo('normal', 0, function() {
                $cover.hide();
            });
        });
    });
});
*/





/* Inserts a new css link if browser is Safari or Chrome
----------------------------------------*/
$(function() {
    $('html').attr('id','jquery-enabled')
    var $link = $('link[rel=stylesheet]:first').clone();
    if (jQuery.browser['safari']) {
        $link.attr({ href: "static/css/safari.css" });
        $('head').append($link);
    } else if (jQuery.browser['opera']) {
        $link.attr({ href: "static/css/opera.css" });
        $('head').append($link);
    }
});


/* Blanks out the search box when user clicks in it
----------------------------------------*/
$(function() {
    var $search = $('#searchtext');
    var val;

    $search.focus(function() {
        val = $search.val();
        $search.val('');
    });
    $search.blur(function() {
        if ($search.val() === '') {
            $search.val(val);
        }
    });
});



/* Sorts the list of entities on the entity-list-page and connections list
----------------------------------------*/
$(function() {

if ($('#search-filter-form').length) {
    var $entitySortBy = $('#search-select');
        var loc = location.href;
        var qs = loc.substring(loc.indexOf('?') + 1, loc.length);

        $entitySortBy.find('option').each(function() {
            var val = $(this).val();

            if (val.indexOf(qs) > -1) {
                $(this).attr('selected', 'selected')
            } else {
                $(this).removeAttr('selected');
            }
        });

        $entitySortBy.change(function() {
            window.location.href = $(this).val();
        });
    }
});



/* Toggles the radio button images to and on/off state on the search form
----------------------------------------*/
$(function() {
    var $searchPage = $('#search-page');

    if ($searchPage.length) {
        $('#people-chk').click(function() {
            change(this);
            window.location.href = $(this).val();
        });

        $('#stories-chk').click(function() {
            change(this);
            window.location.href = $(this).val();
        });

        function change(el) {
            var $this = $(el);
            var $label = $this.parent('label');
            var labelId = $label.attr('id');
            var $other = $this.parent().siblings('label').children('input');
            var $otherLabel = $other.parent('label');
            var otherId = $otherLabel.attr('id');

            //var checked = $other.is(':checked');

            $label.removeClass().addClass(labelId + '-off');

            if ($otherLabel.attr('class').indexOf('off') > -1) {
                $otherLabel.removeClass().addClass(otherId);
            }
        }
    }
});



/* Animates the page back to the top using Scroll To
----------------------------------------*/
$(function() {
    var $backToTop = $('a.btt');
    if ($backToTop.length) {
        $backToTop.click(function() {
            $.scrollTo("body", { duration: 800, axis: "y" });
            return false;
        });
    }
});


/* Toggles the visibility of the comments forms on the story page
* and also displays form if #comments-area is in URL
----------------------------------------*/
$(function() {
    var $storyPage = $('#story-page');

    if ($storyPage.length) {
        var $block46 = $('#comments-area div.block-046');
        var thanks = $('#comments-area p.thanks').get(0);
        var $showMore = $('p.showall a');

        $block46.hide();

        /*
        * If the url contains #comments-area but the thanks message isn't visible then
        * the submit wasn't a success and we need to show the form again;
        */
        if (window.location.hash === '#comments-area' && !thanks) {
            $block46.show();
        }

        //Show form when user clicks 'Add a comment'
        $('#add-comment a').click(function() {
            var $buttonText = $('#add-comment a');
            if ($block46.is(':hidden')) {
                $buttonText.text('Hide form');
            } else {
                $buttonText.text('Add a comment');
            }
            $block46.slideToggle('slow');
            return false;
        });

        //Show all comments
        $showMore.click(function() {
            var $this = $(this);
            var url = '/story_comment/getallcomments?id=' + $this.attr('href');
            var $moreComments = $this.parent().parent().siblings('div.more-comments');

            if (!$moreComments.is(':hidden')) {
                $this.html('Show all comments');
                $moreComments.slideUp();
            } else {
                $.ajax({
                    type: "POST",
                    url: url,
                    success: function(response) {
                        $moreComments.hide().html(response).slideDown('fast');
                        //$this.parent().parent().before(response);
                        $this.html('Show less comments');
                    }
                }); /*AJAX end*/
            }
            return false;
        });
    } //if $storyPage
});



/* Toggles the visibility of the text for the main story on the homepage
----------------------------------------*/
$(function() {
    var block30 = $('#block-030').get(0);

    if (block30) {
        $('p.read-more a', block30).click(function() {
            var $this = $(this);
            var $hiddenDiv = $(this).parent().siblings('div.hidden');
            if ($hiddenDiv.is(':hidden')) {
                $this.text('Show less');
            } else {
                $this.text('Read more');
            }
            $hiddenDiv.slideToggle();
            return false;
        });
    }
});



/* Toggles the amount of facts displayed on 'Interestingly enough' on entity page
----------------------------------------*/
$(function() {
    var $block20 = $('#block-020');

    if ($block20.length) {
        $('#block-020 p.see-all a').click(function() {
            $this = $(this);
            $moreFacts = $this.parent().siblings('div.more-facts');
            if (!$moreFacts.is(':hidden')) {
                $this.html('See all');
                $moreFacts.slideUp();
            } else {
                var url = $this.attr('href') + ".ajax";
                $.ajax({
                    type: "POST",
                    url: url,
                    success: function(response) {
                        $this.html('Show less');
                        $moreFacts.html(response).slideDown();
                    }
                }); /*AJAX end*/
            }
            return false;
        });
    }
});



/* This sets the length of the progress bars if they exist on a page
----------------------------------------*/
$(function() {
    var $progress = $('#content div.progress-bar .top');

    if ($progress.length) {
        $progress.each(function() {
            var $item = $(this);
            var width = $item.width();
            var len = width / 100;
            var val = $(this).attr('title');
            var left = width - Math.round(len * val);
            left = (left === 0) ? (left + 'px') : ('-' + left + 'px');
            $(this).css({ left: left });
        });
    }
});


/* Toggles the visibility of story items on the story page 
----------------------------------------*/
$(function() {
    var $storyPage = $('#story-page');

    if ($storyPage.length) {
        $('#content div.block-040 div.icon a').hover(function() {
            $(this).parents('.block-040').addClass('hover');
        }, function() {
            $(this).parents('.block-040').removeClass('hover');
        });

        $('#content div.block-040 h4').hover(function() {
            $(this).parents('.block-040').addClass('hover');
        }, function() {
            $(this).parents('.block-040').removeClass('hover');
        });

        $('#content div.block-040 div.icon a').click(function() {
            change($(this));
            return false;
        });

        $('#content div.block-040 h4').click(function() {
            change($(this).siblings('div.icon').children('a'));
        });

        function change($this) {
            var $story = $this.parents('div.block-006').children('div.story-clip');
            var closed = $this.hasClass('closed')
            if (closed) {
                $this.removeClass('closed').addClass('opened');
            } else {
                $this.removeClass('opened').addClass('closed');
            }
            $story.slideToggle('fast');
            return false;
        }
    }
});



/* User rating for the Story page 
----------------------------------------*/
$(function() {

    if ($('#rating-form').length) {
        var notScored = true;
        var $starHolder = $('#star-holder');
        var $userRating = $('#user-rating');
        var $ratingForm = $('#rating-form');
        var $rated = $('p#yourated');
        var $hidden = $ratingForm.children('input[type=hidden]');
        var cookieName = 'whoknowswho' + $hidden.attr('id');
        var cookieVal = $.cookie(cookieName);

        //$.cookie('whoknowswho', null);//this stops cookie being stored	
        //var $thanks = $('#thanks');
        //$thanks.hide();

        /* 
        * The first time a user rates a story hide the rating form and show the rating they gave.
        * Store a cookie on their machine to stop them rating the story more than once.
        * Supplying the change=true argument will change the stars to their rating of the story.
        */
        function showRating(data, change) {
            var arr = data.split(':');
            var storyId = arr[0];
            var score = arr[1];
            var value = arr[2];

            $starHolder.show(); //show fixed stars
            $ratingForm.hide(); //hide the rating form

            if (change) {
                $rated.show().text('Thanks for rating!');
                $userRating.html(value);
                var $stars = $('div.star', $starHolder.get(0));

                $stars.each(function() {
                    $star = $(this);
                    if ($star.hasClass('selected')) {
                        $star.removeClass('selected');
                    }
                    if ($stars.index(this) + 1 <= score) {
                        $(this).addClass('selected');
                    }
                });
            } else {
                var t = $rated.show().text();
                $starHolder.hover(
                    function() {
                        $rated.show().text('You have rated this story.');
                    },
                    function() {
                        $rated.show().text(t);
                    }
                )
            }
        }


        if (cookieVal) {
            //this will show story average rating but stop user rating the story again
            showRating(cookieVal, false);
        } else {
            $starHolder.hide();
            $ratingForm.show();
        }

        /* This deals with the ajax request that is sent once the user has selected a value */
        $('.auto-submit-star').rating({
            callback: function(value, link) {
                var $this = $(this);
                var ajaxData = ['story_id=', $hidden.attr('id'), '&user_id=', $hidden.attr('title'), '&score=', $this.attr('value')].join('');
                var cookieData = [$hidden.attr('id'), $this.attr('value'), $this.attr('title')].join(':');

                if (notScored) {
                    $.ajax({
                        type: "POST",
                        url: "/frontend_dev.php/story_rating/update",
                        data: ajaxData,
                        success: function(response) {
                            //alert(response);
                            notScored = false;
                            $.cookie(cookieName, cookieData, { expires: 1000 });
                            showRating(cookieData, true); //supplying true will change the stars to reflect the users rating.
                        }
                    }); /*AJAX end*/
                }
            },

            focus: function(value, link) {
                if (notScored) {
                    $userRating[0].data = $userRating[0].data || $userRating.html();
                    $userRating.html(link.title || 'value: ' + value);
                }
            },

            blur: function(value, link) {
                if (notScored) {
                    $userRating.html($hidden.val());
                }
            }
        });
    }
});


/* 'What is the connection' pop-up box with shadow
----------------------------------------*/
$(function() {

    if ($('#entity-list-page').length) {

        var $block39 = $('#block-039');
        var $shadow = $('#shadow .middle');

        $block39.css({ opacity: 0, visibility: "hidden" });

        $('a.close', $block39.get(0)).click(function() {
            $block39.css({
                'visibility': 'hidden',
                opacity: 0
            });
            return false;
        });
        
        //will hide the pop-up if user clicks anywhere outside of pop-up
        $(document).bind('mousedown', function() {
            $block39.css({
                'visibility': 'hidden',
                opacity: 0
            });
        });
        
        //stops pop-up closing by preventing the event from bubbling up the DOM
        $block39.bind('mousedown', function(event) {
		    event.stopPropagation();
		});

        $('a.witc').click(function() {
            var $this = $(this);
            var url = $this.attr('href') + ".ajax?cache=" + new Date().getTime(); //for IE8 to stop caching of ajax requests
            //alert(url);
            $.ajax({
                type: "POST",
                url: url,
                data: '',
                success: function(response) {
                    var $content = $('div.content', $block39.get(0));
                    $('>span', $content.get(0)).html(response);
                    var height = $content.height();
                    var shadowHeight = (height + 115);
                    var offset = $this.offset();
                    var top = (offset.top - (64 + height)) + 'px';
                    var left = (offset.left - 150) + 'px';

                    $block39.css({
                        visibility: 'visible',
                        opacity: 0,
                        filter: 'alpha(opacity=0)',
                        top: top,
                        left: left
                    }).fadeTo('fast', 1);

                    $shadow.height(height + 15);
                }
            }); /*AJAX end*/

            return false;
        });
    }
});








	

