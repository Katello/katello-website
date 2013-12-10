<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * IRC Page Template
 *
   Template Name:  IRC Page
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

          <iframe src="http://webchat.freenode.net/?channels=#theforeman" id="irc-iframe" />

        </div><!-- end of #content-full -->

<?php get_footer(); ?>
