<?php
/*
Plugin Name: Static Pages
Plugin URI: http://www.BlogsEye.com/
Description: Wraps a them around a static page
Version: 1.1
Author: Keith P. Graham
Author URI: http://www.BlogsEye.com/

This software is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

function kpg_static_init() {
	add_options_page('Static Pages', 'Static Pages', 'manage_options','staticpages','kpg_static_page_control');
}
add_action('admin_menu', 'kpg_static_init');
add_action('wp_ajax_nopriv_static_page', 'kpg_handle_static_page');	
add_action('wp_ajax_static_page', 'kpg_handle_static_page');
	
// the address is in $ajaxurl?
// register kpg_static_page_widget widget
add_action('widgets_init', 'kpg_create_static_page_widget');

function kpg_handle_static_page() {
	static_errorsonoff();
	kpg_handle_static_page_action();
	static_errorsonoff('off');
}
function kpg_handle_static_page_action() {
// go here because htaccess sent us
// this opens a file statically
// must be html or shtml
	global $wp_query;
	if (empty($wp_query)) {
		// create a new $wp_query?
		$wp_query=new WP_Query();
	}
	$content='';
	$head='';
	$script='';
	$options=kpg_static_get_options();
	extract($options);
	$ff=$_SERVER['SCRIPT_URL'];
	$lf=$_SERVER['SCRIPT_URI'];
	$root=$_SERVER['DOCUMENT_ROOT'];
	$f=$root.$ff;
	if (!file_exists($f)) {
		echo "Can't find $ff<br/>";
		exit();
	}

	if (is_dir($f)) {
		if (substr($f,-1)!='/') $f=$f."/";
		if (file_exists($f.'index.html')) {
			$f=$f.'index.html';
			$lf=$lf.'index.html';
		} else if (file_exists($f.'index.shtml')) {
			$f=$f.'index.shtml';
			$lf=$lf.'index.shtml';
		} else if (file_exists($f.'index.htm')) {
			$f=$f.'index.htm';
			$lf=$lf.'index.htm';
		} else {
			echo "Can't find $ff $f<br/>";
			exit();
		}
	}
	// find the extension so we can figure how to handle this guy.
	$j=strrpos($f,'.');
	if ($j===false) {
		echo "don't know how to handle $ff $f<br/>";
		exit();
	}
	$ext=substr($f,$j+1);
/*******************************************/
// start of new code to handle almost anything
// I will modify this as I start to support some of these in special ways.
// for now, If I don't know then it is an object with an iframe fall through.
$tp='ob';
switch($ext) {
case 'html': $ct='text/html'; $tp='ht'; break;
case 'htm': $ct='text/html'; $tp='ht'; break;
case 'shtml': $ct='text/html'; $tp='ht'; break;
case 'xml': $ct='text/xml'; $tp='if'; break;
case 'gif': $ct='image/gif'; $tp='im'; break;
case 'jpeg': $ct='image/jpeg'; $tp='im'; break;
case 'jpg': $ct='image/jpeg'; $tp='im'; break;
case 'atom': $ct='application/atom+xml'; $tp='if'; break;
case 'rss': $ct='application/rss+xml'; $tp='if'; break;
case 'mml': $ct='text/mathml'; break;
case 'txt': $ct='text/plain'; $tp='ht'; break;
case 'jad': $ct='text/vnd.sun.j2me.app-descriptor'; break;
case 'wml': $ct='text/vnd.wap.wml'; break;
case 'htc': $ct='text/x-component'; break;
case 'png': $ct='image/png'; $tp='im'; break;
case 'tif': $ct='image/tiff'; $tp='im'; break;
case 'tiff': $ct='image/tiff'; $tp='im'; break;
case 'wbmp': $ct='image/vnd.wap.wbmp'; $tp='im'; break;
case 'ico': $ct='image/x-icon'; $tp='im'; break;
case 'jng': $ct='image/x-jng'; $tp='im'; break;
case 'bmp': $ct='image/x-ms-bmp'; $tp='im'; break;
case 'svg': $ct='image/svg+xml'; $tp='im'; break;
case 'webp': $ct='image/webp'; $tp='im'; break;
case 'jar': $ct='application/java-archive'; break;
case 'war': $ct='application/java-archive'; break;
case 'ear': $ct='application/java-archive'; break;
case 'hqx': $ct='application/mac-binhex40'; break;
case 'doc': $ct='application/msword'; break;
case 'pdf': $ct='application/pdf'; $tp='pdf'; break;
case 'ps': $ct='application/postscript'; $tp='pdf'; break;
case 'eps': $ct='application/postscript'; $tp='pdf'; break;
case 'ai': $ct='application/postscript'; $tp='pdf'; break;
case 'rtf': $ct='application/rtf'; break;
case 'xls': $ct='application/vnd.ms-excel'; break;
case 'ppt': $ct='application/vnd.ms-powerpoint'; break;
case 'wmlc': $ct='application/vnd.wap.wmlc'; break;
case 'kml': $ct='application/vnd.google-earth.kml+xml'; break;
case 'kmz': $ct='application/vnd.google-earth.kmz'; break;
case '7z': $ct='application/x-7z-compressed'; break;
case 'cco': $ct='application/x-cocoa'; break;
case 'jardiff': $ct='application/x-java-archive-diff'; break;
case 'jnlp': $ct='application/x-java-jnlp-file'; break;
case 'run': $ct='application/x-makeself'; break;
case 'prc': $ct='application/x-pilot'; break;
case 'pdb': $ct='application/x-pilot'; break;
case 'rar': $ct='application/x-rar-compressed'; break;
case 'rpm': $ct='application/x-redhat-package-manager'; break;
case 'sea': $ct='application/x-sea'; break;
case 'swf': $ct='application/x-shockwave-flash'; break;
case 'sit': $ct='application/x-stuffit'; break;
case 'tcl': $ct='application/x-tcl'; break;
case 'tk': $ct='application/x-tcl'; break;
case 'der': $ct='application/x-x509-ca-cert'; break;
case 'pem': $ct='application/x-x509-ca-cert'; break;
case 'crt': $ct='application/x-x509-ca-cert'; break;
case 'xpi': $ct='application/x-xpinstall'; break;
case 'xhtml': $ct='application/xhtml+xml'; break;
case 'zip': $ct='application/zip'; break;
case 'deb': $ct='application/octet-stream'; break;
case 'dmg': $ct='application/octet-stream'; break;
case 'eot': $ct='application/octet-stream'; break;
case 'iso': $ct='application/octet-stream'; break;
case 'img': $ct='application/octet-stream'; break;
case 'msi': $ct='application/octet-stream'; break;
case 'msp': $ct='application/octet-stream'; break;
case 'msm': $ct='application/octet-stream'; break;
case 'mid': $ct='audio/midi'; break; 
case 'midi': $ct='audio/midi'; break; 
case 'kar': $ct='audio/midi'; break;
case 'mp3': $ct='audio/mpeg'; break;
case 'ogg': $ct='audio/ogg'; break;
case 'ra': $ct='audio/x-realaudio'; break;
case '3gpp': $ct='video/3gpp'; break;
case '3gp': $ct='video/3gpp'; break;
case 'mpeg': $ct='video/mpeg'; break;
case 'mpg': $ct='video/mpeg'; break;
case 'mov': $ct='video/quicktime'; break;
case 'flv': $ct='video/x-flv'; break;
case 'mng': $ct='video/x-mng'; break;
case 'asx': $ct='video/x-ms-asf'; break;
case 'asf': $ct='video/x-ms-asf'; break;
case 'wmv': $ct='video/x-ms-wmv';  $tp='vid'; break;
//case 'avi': $ct='video/avi'; $tp='vid';  break;
case 'avi': $ct='video/mpeg'; $tp='em';  break;
case 'm4v': $ct='video/mp4'; break;
case 'mp4': $ct='video/mp4'; break;
default:
	$ct='application/octet-stream';
}

if (!empty($_GET)&&array_key_exists('passthru',$_GET)) {
	//just do it man - asking for a passthru
	//ob_end_clean();
	$title=basename($lf);
	$flen=filesize($f);
	//header("Content-Disposition: attachment; filename=\"$title\"");
	header("Content-Length: $flen");
	header("Content-type: $ct");
	readfile($f);
	exit();
}

switch ($tp) {
	case 'ob':
		// embeded object with a fallback iframe
		// width and height are video by default
		// audio is height of 40px? 
		$width=$obwidth;
		$height=$obheight;
		if (strpos($ct,'video')!==false) {
			$height=$vidheight;
			$width=$vidwidth;
		}
		if (strpos($ct,'audio')!==false) {
			$height=$audioheight;
			$width=$audiowidth;
		}
		$title=basename($lf);
		$content="<object type=\"$ct\" data=\"$title?passthru=1\" width=\"$width\" height=\"$height\" 		scale=\"noborder\"
 ><iframe  src=\"$title?passthru=1\" style=\"width:$width".'px'.";height:$height".'px'.";\" ></iframe></object>";
		break;
	case 'im':
		// simple include no width or height
		$title=basename($lf);
		$content="<img src=\"$title?passthru=1\"/>";
		break;
	case 'pdf':
		// embed pdf using ob width and height
		$height=$pdfheight;
		$width=$pdfwidth;
		$title=basename($lf);
		$content="<object type=\"$ct\" data=\"$title?passthru=1#FitH\" width=\"$width\" height=\"$height\" >
		<iframe  src=\"$title?passthru=1#FitH\" style=\"width:$width".'px'.";height:$height".'px'.";\" ></iframe></object>";
		// figure out how to use fith,top
		break;
	case 'if':
		$height=$ifheight;
		$width=$ifwidth;
		$title=basename($lf);
		// just an iframe - no embed or obect
		$content="<iframe  src=\"$title?passthru=1\" style=\"width:$width".'px'.";height:$height".'px'.";\" ></iframe>";
	case 'em':
		//use embed for vids - see how it works - for avi test
		$title=basename($lf);
// test out the html5 video tag.		
		$content="
		<video height=\"$vidheight\" width=\"$vidwidth\" controls=\"controls\">
		<source src=\"$title?passthru=1\" type=\"$ct\" />
		Your browser does not support the video tag.
		</video>
		"; 
		$content="
			<object type=\"$ct\" data=\"$title?passthru=1\"
			width=\"$vidwidth\"
			height=\"$vidheight\"
			scale=\"noborder\"
			title=\"$title\">
			<param name=\"movie\" value=\"$title?passthru=1\">
			<param name=\"scale\" value=\"aspect\" />
			<p>
			Your browser does not support this file type.
			</p>
			</object>
		"; 
		$content="
		<embed
		width=\"$vidwidth\"
		height=\"$vidheight\"
		src=\"$title?passthru=1\" 
		scale=\"noborder\"
		type=\"$ct\">
			Sorry, not supported
		</embed>";
		break;
	case 'vid':
		$title=basename($lf);
		// use the wordpress shortcode for video see if it works
		$content="
		<video height=\"$vidheight\" width=\"$vidwidth\" controls=\"controls\">
		<source src=\"$title?passthru=1\" type=\"$ct\" />
		Your browser does not support the video tag.
		</video>
		"; 
		break;
	case 'ht':
		// html very long - use the existing if statement below - I know it works.
		break;
	default:
		// no idea how I got here - redirect to the file without any questions asked
		//header("location: $ft?passthru=1");
		echo "You can't get here from there";
		exit();
		// actually, I think I can take the default out.
}


// end of new code - I hope that this works
/*******************************************/	
	$prevnext='';
	if ($tp!='ht'||$ext='txt') {
		$title=basename($lf); //for text files
		// create the prev/next stuff
		// look on the directory for a list of files with the extension I want
		$dir=str_replace('/'.$title,'',$f);
		// look of the extension on the disk.
		$flist=array();
		$fcount=0;
        if (($handle = opendir($dir))) {
            while ($file = readdir($handle)) {
				if (is_file($dir . '/' . $file)) {
					$fcount++;
					$j=strrpos($file,'.');
					if ($j!==false) {
					    if (substr($file,$j+1)==$ext) {
							$flist[]=$file;
						} else {
							//echo "\r\n<!-- found".substr($file,$j+1)."-->\r\n";
						}
					}
				}
            }
            closedir($handle);
        } else {
			//echo "<!-- not a dir? $dir -->";
		}
		// have a list of the files in the array
		$j=array_search($title,$flist);
		$prevnext=$title;
		if ($j!==false) {
			if ($j>0) {
				$prevnext="<a href=\"".$flist[$j-1]."\">&lt;prev</a>&nbsp;".$prevnext; 
			}
			if ($j<count($flist)-1) {
				$prevnext=$prevnext."&nbsp;<a href=\"".$flist[$j+1]."\">next&gt;</a>&nbsp;"; 
			}
		} else {
			//echo "<!--\r\n\r\n";
				//echo " count=$fcount\r\n";
				//echo " dir=$dir\r\n";
				//echo " extenstion=$ext\r\n";
				//print_r($flist);
			//echo "\r\n\r\n-->";
		}
	}


 	if ($tp=='ht') { // doing an html file
		$prevnext='';

		$content=file_get_contents($f);
		$head=$content;
		// split the head from the body
		$i=stripos($content,'<body');
		if ($i===false) {
			$i=stripos($content,'</head');
		}
		if ($i!==false) {
			$content=substr($content,$i+1);
			$i=strpos($content,'>');
			if ($i!==false) {
				$content=substr($content,$i+1);
			}
			$i=stripos($content,'</body');
			if ($i===false) $i=strlen($content);
			$content=substr($content,0,$i);
		} else {
			$content="\r\n<!-- no head or body tag found -->\r\n".$content;
		}
		// now find the head
		$i=stripos($head,'</head');
		if ($i!==false) {
			$head=substr($head,0,$i);
		} else {
			$i=stripos($head,'<body');
			if ($i!==false) {
				$head=substr($head,0,$i);
			}
		}
		// get the title
		$i=stripos($head,'<title');
		$title='';
		if ($i!==false) {
			$i=stripos($head,'>',$i+1)+1;
			$j=stripos($head,'</titl',$i);
			$title=substr($head,$i,$j-$i);
		} else {
		
		}
		$title=trim($title);
		if (empty($title)) {
			// look for an h1 in the body
			$i=stripos($content,'<h1');
			if ($i!==false) {
				// got an h1
				$i=stripos($content,'>',$i+1)+1;
				$j=stripos($content,'</h1',$i);
				$title=substr($content,$i,$j-$i);
			}		
		}
		$title=trim($title);
		if (empty($title)) {
			// look for an h1 in the body
			$i=stripos($content,'<h2');
			if ($i!==false) {
				// got an h2
				$i=stripos($content,'>',$i+1)+1;
				$j=stripos($content,'</h2',$i);
				$title=substr($content,$i,$j-$i);
			}		
		}
		$title=trim($title);
		if (empty($title)) {
			// look for an h3 in the body
			$i=stripos($content,'<h3');
			if ($i!==false) {
				// got an h1
				$i=stripos($content,'>',$i+1)+1;
				$j=stripos($content,'</h3',$i);
				$title=substr($content,$i,$j-$i);
			}		
		}
		$title=strip_tags($title);
		if (empty($title)) {
			// not title try using the actual URL
			$title=basename($lf);
		}
		// find any scripts that may have been in the header. This in case the static page loaded any javascript libraries
		$script="";
		$i=stripos($head,'<script');
		while ($i!==false) {
			// need to find the location of either a '/>' or a '</script'>, wichever is closer
			$j=stripos($head,'/>',$i+7);
			$k=stripos($head,'</script>',$i+7);
			if ($j===false) {
				// no />
				if ($k!==false) {
					// there is a $k, let's hope that is closing our script
					$script.=substr($head,$i,$k+9-$i)."\r\n";
				}
			} else if ($k===false) {
				// $j is not false if we get here
				// we hope that the script was closed with a />
				$script.=substr($head,$i,$j+2-$i)."\r\n";
			} else {
				// both are found, we need to catch the closest - the other probably closes something else.
				// of course this breaks down completely if the static page is mangled.
				if ($j>$k) {
					// use k$+2 as end of script
					$script.=substr($head,$i,$k+9-$i)."\r\n";
				} else {
					// the '/script' was closer
					$script.=substr($head,$i,$j+9-$i)."\r\n";
				}
			}
			$i=stripos($head,'<script',$i+7); // start again
		}
		
		
		
		// just for the hell of it, get rid of the server side includes
		
		$content=str_replace('<!--#','<!-- pound sign ',$content);
	
	// end of html type data
	}  
	$new_content="
	
	<!-- start of Static Page -->
	
	<!-- put a container around page, might help, can't hurt -->
	";

	$now=date('Y/m/d H:i:s',time() + ( get_option( 'gmt_offset' ) * 3600 ));
	$rec=array($title,$now,0);
	if (array_key_exists($lf,$recent)) $rec=$recent[$lf];
	$rec[2]++;
	$rec[1]=$now;
	$rec[0]=$title;
	$recent[$lf]=$rec;
	// sort recent by link name
	ksort($recent);
	$options['recent']=$recent;
	update_option('kpg_static_options',$options);
	
    if (!empty($script)) {
		$new_content.="
		<!-- scripts go here -->
		".$script."
		<!-- end of scripts -->";
	}
	$new_content.="
	<div style=\"position:relative;\">
	<h4>$prevnext</h4>

	".$content."
	</div>";
	$new_content.="
	
	<!-- end of of Static Page -->
	
	";
	$post=get_post($id);
	if (empty($post)) {
		$post = new stdClass();
		$post->ID= $id;
		$post->post_category= array($category); //Add some categories. an array()???
		$post->post_status='publish'; //Set the status of the new post.
		$post->post_type='page'; //Sometimes you might want to post a page.
		$post->comment_status='open';
	}
	$post->post_title=$title; //The title of your post.
	$post->post_content=$new_content; //The full text of the post.
	$post->post_excerpt= $new_content; //For all your post excerpt needs.
	
	$wp_query->queried_object=$post;
	$wp_query->post=$post;
	$wp_query->found_posts = 1;
	$wp_query->post_count = 1;
	$wp_query->max_num_pages = 1;
	$wp_query->is_single = 1;
	$wp_query->is_404 = false;
	$wp_query->is_posts_page = 1;
	$wp_query->posts = array($post);
	$wp_query->page=true;
	$wp_query->is_post=false;
	$wp_query->page=true;

	// find the main index or single page for the theme.
	$td=get_template_directory();
	$t= $td.'/'.$template;
	if (!file_exists($t)) {
		$t=$td.'/index.php';
	}
	if (strpos($f."\t",".txt\t")===false) { // let wordpress mess with the text file.
		remove_filter( 'the_content', 'wpautop' ); // don't want it messing with the code
	}
	include($t);
	// log the results
	exit();
}


function kpg_static_get_options() {
	$opts=get_option('kpg_static_options');
	if (empty($opts)||!is_array($opts)) $opts=array();
	$options=array(
		'recent'=>array(),
		// file types to remember
		'chkhtml'=>'Y',
		'chkhtm'=>'Y',
		'chkshtml'=>'Y',
		'chktxt'=>'Y',
		'chkmp3'=>'N',
		'chkavi'=>'N',
		'chkpdf'=>'Y',
		'chkm4a'=>'N',
		'chkogg'=>'N',
		'chkwav'=>'N',
		'chkwmv'=>'N',
		'id'=>'0',
		'category'=>'uncategorized',
		'pdfwidth'=>'800',
		'pdfheight'=>'1024',
		'ifwidth'=>'800',
		'ifheight'=>'1024',
		'obwidth'=>'640',
		'obheight'=>'400',
		'vidwidth'=>'640',
		'vidheight'=>'400',
		'audiowidth'=>'512',
		'audioheight'=>'40',
		'template'=>'index.php'
	);
	$ansa=array_merge($options,$opts);
	if (empty($ansa['recent'])||!is_array($ansa['recent'])) $ansa['recent']=array();
	if (empty($ansa['id'])) $ansa['id']='0';
	if (empty($ansa['category'])) $ansa['category']='uncategorized';
	if (empty($ansa['template'])) $ansa['template']='index.php';
	return $ansa;
}

// here is the options page
function kpg_static_page_control() {
    include('includes/static-page-options.php');

}
function static_errorsonoff($old=null) {
	$debug=true;  // change to true to debug, false to stop debugging.
	if (!$debug) return;
	if (empty($old)) return set_error_handler("static_ErrorHandler");
	restore_error_handler();
}
function static_ErrorHandler($errno, $errmsg, $filename, $linenum, $vars) {
	// write the answers to the file
	// we are only conserned with the errors and warnings, not the notices
	//if ($errno==E_NOTICE || $errno==E_WARNING) return false;
	$serrno="";
	if ((strpos($filename,'static')==false)&&(strpos($filename,'options-general.php')==false)) return false;
	switch ($errno) {
		case E_ERROR: 
			$serrno="Fatal run-time errors. These indicate errors that can not be recovered from, such as a memory allocation problem. Execution of the script is halted. ";
			break;
		case E_WARNING: 
			$serrno="Run-time warnings (non-fatal errors). Execution of the script is not halted. ";
			break;
		case E_NOTICE: 
			$serrno="Run-time notices. Indicate that the script encountered something that could indicate an error, but could also happen in the normal course of running a script. ";
			break;
		default;
			$serrno="Unknown Error type $errno";
	}
	if (strpos($errmsg,'modify header information')) return false;
 
	$msg="
	Error number: $errno
	Error type: $serrno
	Error Msg: $errmsg
	File name: $filename
	Line Number: $linenum
	---------------------
	";
	// write out the error
	$f=fopen(dirname(__FILE__)."/static_debug_output.txt",'a');
	fwrite($f,$msg);
	fclose($f);
	return false;
}
function kpg_create_static_page_widget() {
//add_action('widgets_init', create_function('', 'return register_widget("kpg_static_page_widget");'));
	require('widget/static-page-widget.php');
	register_widget("kpg_static_page_widget");
}
?>