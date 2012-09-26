=== Static Pages ===
Tags: Static, Pages, Wrap, Theme, pdf, html, txt, video, music, audio, mp3, avi
Requires at least: 3.2
Tested up to: 3.5
Stable tag: 1.1
Donate link: http://www.blogseye.com/buy-the-book/
Contributors: Keith P. Graham
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Automatically wrap a WordPress Theme around static HTML pages, pdf files, audio or video files. Add the look and feel of Wordpress to legacy static files.

== Description ==

The Static Pages plugin takes any existing html file and wraps it with a WordPress theme. Legacy html files can take advantage of all of the WordPress features such as sidebars, widgets and shortcodes. It can embed Adobe PDF files, or audio and video files in a wordpress theme

The plugin works with a variety of file types. 

For html type files it extracts the title of the page, the content and any javascript in the header and throws away the rest. It then creates a fake post which it displays in the currently active theme. The legacy web page will appear as a WordPress page using the theme formatting with the theme headers, sidebars and footers. The plugin leaves all of the original file's BODY intact. If the original static page contained headings, menus, sidebars, etc, they will remain and be wrapped in the WordPress theme. Server Side includes (SSI) will, however, be ignored by PHP.

For PDF, audio and video files it displays the pdf on a web page by embedding it. 

After installing the plugin it is necessary to alter or add an .htaccess file to the area in your site where the static pages reside. The plugin generates the correct .htaccess directives and you can find them on the plugin's settings page. You can add the lines to the WordPress generated .htaccess after the WordPress section.

Note: The plugin does not change anything on your website. In order to make it work, you have to create an htaccess file and copy it to your server.  

Since the static page is not properly a part of wordpress and is not in the WordPress database, the WordPress comment system will not work correctly with them. It is possible, however to direct all comments made on a static page to another page. You can select an existing WordPress page from the configuration options page. It is a good idea to create a simple page that does nothing but collect comments from the static pages.

By default the plugin will use the index.php file in your theme to wrap static pages, but if you have file such as single.php or other custom theme page, you can enter its name on the configuration page.

The main drawback of the system is that older pages often have hand crafted headers, sidebars and footers that may even use absolute positioning. The static page may display these on top of your theme, in which case you may want to alter the orginal files.

The plugin saves the static content that it finds and a widget is included that can be used put a list of static pages on your sidebar so they can be linked directly.

I have been updating my websites since the first version of Netscape Navigator. I created this plugin to wrap a wordpress theme around thousands of pages on my websites.


== Installation ==

1. Install the Static Pages Plugin either via the WordPress.org plugin directory, or by uploading the files to your server.
2. After activating the Static Pages Plugin, you can change the theme's template page and specify the page that will receive your comments on the plugin's settings page.
3. Copy the .htaccess commands on the plugin's settings page. Paste these into your WordPress .htaccess file, or create a new .htaccess file. Copy this to the server.
4. Test by browsing to a static web page to see if the WordPress theme appears around the page.
5. You can drag the widget to the sidebar to display links to discovered static content.

== Frequently Asked Questions ==

= Where do I put the .htaccess file? =
The .htaccess file belongs in the same directory or in a directory above the one that has the static files. If you have a directory called "salesinfo" with html files in it, you can place the .htaccess file in that directory. You can place a copy in any directory where you have static files. You only have to place it in the topmost directory as it will work on all subdirectories.
You can also place it in your document root directory where it will affect every static HTML file on your website.
Be careful not to replace any existing .htaccess files. Copy the existing .htaccess files to your local disk, edit them, and paste the new directives to the end of the original .htaccess file.
WordPress creates an .htaccess file at your installation root. Be careful not to delete or overlay this. You must edit it and place the new directives at the end of it.

= My web pages look crazy in the WordPress theme. =
The plugin just slams the old page into the new formatted page. It makes no attempt to correct any of the formatting in the old page. If there are headers, side menus, footers or fancy formatted sections, especially with absolute positioning, the only hope is to edit the static file to make it better behaved.

= I get Error 500 everywhere on my website =
This is a problem with your .htaccess file. Either delete any new .htaccess files, or restore them to the original state. You may have made a typo when you created the new files or you may have screwed up the original. If there is a problem that can't be fix, then you need to delete the .htaccess file outright. 
If you lose your permalinks in WordPress, you need to go into WordPress settings and select Permalinks. Change the permalink structure, and save it. Then change it back to where you want it and save it again. This will recreate your WordPress .htaccess file.

= I get a 403 trying to access files on a directory =
This happens because there is no index file in the directory. Copy the main page in the directory naming it "index.html" and try again.

= Notepad won't let me save or create a file as .htaccess =
Windows doesn't like files starting with a dot. Try copying an existing .htaccess file from the internet and edit it.
You can als edit a file named htaccess without the dot. Copy this up to your website using ftp, and then use your ftp client to rename it. I have done this with both Filezilla and WS_FTP.

= What other file types can I use to wrap a template around embeded files =
I have set up the plugin so that it works with html, txt, pdf, some music files and some video files. I put a section in the code to handle a large list, but not all will work. The settings page will create the contents of an .htaccess file for a few that I have tested. (Tested means that I got it to work most of the time - it does not mean it worked perfectly.)
If your browser can handle a file type then the plugin will work. You can't be sure that a visitor's browser will work. Just add a new line to the .htaccess file for one of the file types listed and see what happens. Report back success or failure.
Here is a list of file types that may work.
html, htm, shtml, xml, gif, jpeg, jpg, atom, rss, mml, txt, jad, wml, htc, png, tif, tiff, wbmp, ico, jng, bmp, svg, webp, jar, war, ear, hqx, doc, pdf, ps, eps, ai, rtf, xls, ppt, wmlc, kml, kmz, 7z, cco, jardiff, jnlp, run, prc, pdb, rar, rpm, sea, swf, sit, tcl, tk, der, pem, crt, xpi, xhtml, zip, deb, dmg, eot, iso, img, msi, msp, msm, mid, midi, kar, mp3, ogg, ra, 3gpp, 3gp, mpeg, mpg, mov, flv, mng, asx, asf, wmv, avi, m4v, mp4. 
WARNING: if you use htaccess to send image files (jpg, gif, etc) to the plugin then you will not be able to display images on your website normally. If you have a directory of images that you want to wrap, you can put a new .htaccess file in the directory and use the plugin to wrap them - but the images cannot be accessed in any other way.

== Changelog ==

= 0.9 =
* Initial release

= 1.0 =
* Duplicate of 0.9 in error

= 1.1 =
* Page log keeps a list of pages that are being hit. Added an error handling routine to track bugs.
* added a sidebar widget to display all the static pages found. This lets you put links to these pages in your sidebar.
* added support for pdf, txt, and many other file formats. (not all will work on all installations).

== Support ==
This plugin is free and I expect nothing in return. Please rate the plugin at:
http://wordpress.org/extend/plugins/ttatic-pages-plugin/
If you wish to support my programming, buy my book: 
<a href="http://www.blogseye.com/buy-the-book/">Error Message Eyes: A Programmer's Guide to the Digital Soul</a>
Other plugins:
<a href="http://wordpress.org/extend/plugins/permalink-finder/">Permalink Finder Plugin</a>
<a href="http://wordpress.org/extend/plugins/open-in-new-window-plugin/">Open in New Window Plugin</a>
<a href="http://wordpress.org/extend/plugins/kindle-this/">Kindle This - publish blog to user's Kindle</a>
<a href="http://wordpress.org/extend/plugins/stop-spammer-registrations-plugin/">Stop Spammer Registrations Plugin</a>
<a href="http://wordpress.org/extend/plugins/no-right-click-images-plugin/">No Right Click Images Plugin</a>
<a href="http://wordpress.org/extend/plugins/collapse-page-and-category-plugin/">Collapse Page and Category Plugin</a>
<a href="http://wordpress.org/extend/plugins/custom-post-type-list-widget/">Custom Post Type List Widget</a>

