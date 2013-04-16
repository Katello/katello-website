<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * FAQ Page Template
 *
   Template Name:  FAQ Page
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

            <h1>Frequently Asked Questions</h1>

            <strong>Q.)</strong>&nbsp;Does Katello work on CentOS?<br>
            <strong>A.)</strong>&nbsp;Theoretically it will work on CentOS, but we’re not officially supporting it yet. Please give it a try, and patches are welcome!</p>
            <p><strong>Q.)</strong>&nbsp;What about Spacewalk?<br>
				    <strong>A.)</strong> The Spacewalk project will continue to be the upstream community project for the Satellite version 5 offering.  The Katello project is now an upstream component for the next generation release of Satellite, yet to be released into market.  Stay tuned for updates and announcements on how Katello will contribute to the next generation Satellite offering.<br/></p>
            <p><strong>Q.)</strong>&nbsp;How do I get started?<br>
            <strong>A.)</strong>&nbsp;<a href="https://fedorahosted.org/katello/wiki/Install">Click here. Do it now!</a></p>
            <p><strong>Q.)</strong>&nbsp;How is Katello licensed?<br>
            <strong>A.)</strong>&nbsp;Katello source code is licensed with GPLv2+, you can view a copy of the license&nbsp;<a href="http://www.katello.org/license.html">here</a>.</p>

        </div><!-- end of #content-full -->

<?php get_footer(); ?>
