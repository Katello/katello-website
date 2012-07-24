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
            <strong>A.)</strong>&nbsp;The Satellite product will continue to use the upstream Spacewalk project. Similarly the Katello project will be an upstream component of the CloudForms product. We first announced the Katello project and the future of Satellite at the 2011 Red Hat Summit. You can review those presentation slides here:&nbsp;<a target="_blank" href="http://www.redhat.com/summit/2011/presentations/summit/whats_next/thursday/summit-2011.warner_sanders_t_1400_future_of_satellite-v7.pdf" title="The Future of Red Hat Network Satellite - A New Architecture Enabling Traditional Datacenters &amp; the Cloud ">The Future of Red Hat Network Satellite: A New Architecture Enabling Traditional Datacenters &amp; the Cloud</a></p>
            <p><strong>Q.)</strong>&nbsp;How do I get started?<br>
            <strong>A.)</strong>&nbsp;<a href="https://fedorahosted.org/katello/wiki/Install">Click here. Do it now!</a></p>
            <p><strong>Q.)</strong>&nbsp;How is Katello licensed?<br>
            <strong>A.)</strong>&nbsp;Katello source code is licensed with GPLv2+, you can view a copy of the license&nbsp;<a href="http://www.katello.org/license.html">here</a>.</p>

        </div><!-- end of #content-full -->

<?php get_footer(); ?>
