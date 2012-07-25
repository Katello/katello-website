<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * YouTube Channel Page Template
 *
   Template Name:  YouTube Channel Page
 *
 * @file           irc.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2011 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/irc.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>

        <div id="content-full" class="grid col-940">
        
          <?php $options = get_option('responsive_theme_options'); ?>

          <div id="video-page">
            <h1>Project Videos and Screencasts</h1>

            <div id="player"></div>
          </div>
<script>
/*
Copyright 2011 : Simone Gianni <simoneg@apache.org>

Released under The Apache License 2.0 
http://www.apache.org/licenses/LICENSE-2.0

*/

(function($) {
    function createPlayer(jqe, video, options) {
        var ifr = $('iframe', jqe);
        if (ifr.length === 0) {
            ifr = $('<iframe scrolling="no">');
            ifr.addClass('player');
        }
        var src = 'http://www.youtube.com/embed/' + video.id;
        if (options.playopts) {
            src += '?';
            for (var k in options.playopts) {
                src+= k + '=' + options.playopts[k] + '&';
            }  
            src += '_a=b';
        }
        ifr.attr('src', src);
        jqe.append(ifr);  
    }
    
    function createCarousel(jqe, videos, options) {
        var car = $('div.carousel', jqe);
        if (car.length === 0) {
            car = $('<div>');
            car.addClass('carousel');
            jqe.append(car);
            
        }
        $.each(videos, function(i,video) {
            options.thumbnail(car, video, options); 
        });
    }
    
    function createThumbnail(jqe, video, options) {
        var imgurl = video.thumbnails[0].url;
        var img = $('img[src="' + imgurl + '"]');
        if (img.length !== 0) return;
        img = $('<img>');    
        img.addClass('thumbnail');
        jqe.append(img);
        img.attr('src', imgurl);
        img.attr('title', video.title);
        img.click(function() {
            options.player(options.maindiv, video, $.extend(true,{},options,{playopts:{autoplay:1}}));
        });
    }
    
    var defoptions = {
        autoplay: false,
        user: null,
        carousel: createCarousel,
        player: createPlayer,
        thumbnail: createThumbnail,
        loaded: function() {},
        playopts: {
            autoplay: 0,
            egm: 1,
            autohide: 1,
            fs: 1,
            showinfo: 0
        }
    };
    
    
    $.fn.extend({
        youTubeChannel: function(options) {
            var md = $(this);
            md.addClass('youtube');
            md.addClass('youtube-channel');
            var allopts = $.extend(true, {}, defoptions, options);
            allopts.maindiv = md;
            $.getJSON('http://gdata.youtube.com/feeds/users/' + allopts.user + '/uploads?alt=json-in-script&format=5&callback=?', null, function(data) {
                var feed = data.feed;
                var videos = [];
                console.log(feed);
                $.each(feed.entry, function(i, entry) {
                    var video = {
                        title: entry.title.$t,
                        id: entry.id.$t.match('[^/]*$'),
                        thumbnails: entry.media$group.media$thumbnail
                    };
                    videos.push(video);
                });
                allopts.allvideos = videos;
                allopts.carousel(md, videos, allopts);
                allopts.player(md, videos[0], allopts);
                allopts.loaded(videos, allopts);
            });
        } 
    });
    
})(jQuery);
        
jQuery(document).ready(function() {
    jQuery('#player').youTubeChannel({user:'katelloproject'});
});</script>
        </div><!-- end of #content-full -->

<?php get_footer(); ?>
