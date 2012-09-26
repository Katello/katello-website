<?php
// break out the options page - lower memory requirements and make programming easier
	$ajax_url=admin_url('admin-ajax.php');
	$ajax_url=substr($ajax_url,strpos($ajax_url,'/',8));
	$options=kpg_static_get_options();
	extract($options);
	
	$nonce='';	
	
	if (array_key_exists('kpg_static_recent_control',$_POST)) $nonce=$_POST['kpg_static_recent_control'];
	if (!empty($nonce)&&wp_verify_nonce($nonce,'kpg_static_update')) {
		// clear history
		$recent=array();
		$options['recent']=$recent;
		update_option('kpg_static_options',$options);
		echo "<h2>Deleted Static Link History</h2>";
	}
	
	$nonce='';	
	if (array_key_exists('kpg_static_types_control',$_POST)) $nonce=$_POST['kpg_static_types_control'];
	if (!empty($nonce)&&wp_verify_nonce($nonce,'kpg_static_update')) {
		// save the types
		// get the check boxes
		$def=array(
			'chkhtml'=>'Y',
			'chkhtm'=>'Y',
			'chkshtml'=>'Y',
			'chktxt'=>'Y',
			'chkmp3'=>'N',
			'chkmp3'=>'N',
			'chkavi'=>'N',
			'chkpdf'=>'Y',
			'chkm4a'=>'N',
			'chkogg'=>'N',
			'chkwav'=>'N',
			'chkwmv'=>'N'
		);
		$ansa=array_merge($def,$_POST);

		foreach($ansa as $key=>$val) {
			if (substr($key,0,3)=='chk') {
			    // echo "<!-- \r\n\r\n updating data $key $val \r\n\r\n-->";
				if ($val!='Y') $val='N';
				$options[$key]=$val;
			}
		}
		update_option('kpg_static_options',$options);
		echo "<h2>Updated Type Preferences</h2>";
	}
	$nonce='';	
	
	if (array_key_exists('kpg_static_log_control',$_POST)) $nonce=$_POST['kpg_static_log_control'];
	if (!empty($nonce)&&wp_verify_nonce($nonce,'kpg_static_update')) {
		// clear the cache
		$f=dirname(__FILE__)."/static_debug_output.txt";
		if (file_exists($f)) {
			unlink($f);
			echo "<h2>Deleted Error Log File</h2>";
		}	
	}
	$nonce='';	

	if (array_key_exists('kpg_static_control',$_POST)) $nonce=$_POST['kpg_static_control'];
	if (!empty($nonce)&&wp_verify_nonce($nonce,'kpg_static_update')) {
		if (array_key_exists('id',$_POST)) $id=$_POST['id'];
		$options['id']=$id;
		if (array_key_exists('template',$_POST)) $template=$_POST['template'];
		$options['template']=$template;
		// check the box sizes
		$fdims=array('pdfwidth','pdfheight','obwidth','obheight','ifwidth','ifheight','vidwidth','vidheight','audiowidth','audioheight');
        foreach ($fdims as $dim) {
			if (array_key_exists($dim,$_POST)) $options[$dim]=$_POST[$dim];
		}		
		update_option('kpg_static_options',$options);
		extract($options);
	}
	
	// create the nonce
	$nonce=wp_create_nonce('kpg_static_update');
 
		
?>

<div class="wrap">
  <h2>Static Pages Plugin Options</h2>
  <p>Automatically wraps static web pages with a WordPress theme.</p>
  <p>The Static Pages Plugin is installed and working correctly.</p>
  <fieldset style="border:thin #707070 solid;padding:4px">
  <legend>.htaccess File</legend>
  <p>In order for the plugin to work, you must copy the lines below and paste them into an .htaccess file. The .htaccess file
    can be the main one used by wordpress, or it can be in the directory that contains the html files that you wish to wrap with the wordpress theme.</p>
  <p>If you add it to your wordpress htaccess file it must go outside and below the wordpress block.</p>
  <h4>File Types</h4>
  <script type="text/javascript">
function kpg_sp_click() {
var targ=document.getElementById("kpg_sp_htaccess");
var inner="# START Static Page Plugin\r\n";
inner+="&lt;IfModule mod_rewrite.c&gt;\r\n";
inner+="RewriteEngine On\r\n";
inner+="RewriteBase /\r\n";
for (j=0;j<document.DOIT2.elements.length;j++) {
	var n=document.DOIT2.elements[j].name;
	var m=n.substring(3);
	if (n.substring(0,3)=='chk') {
		if (document.DOIT2.elements[j].checked) { 
		  inner+="RewriteRule ^(.+)\."+m+"$  <?php echo $ajax_url; ?>?action=static_page [L,NC,QSA]\r\n";
		} else {
			//inner+=" debug: "+m+"   "+n+"    \r\n";
		}
	}
}
inner+="&lt;/IfModule&gt;\r\n";
inner+="# END Static Page Plugin\r\n";
targ.innerHTML=inner;
}
</script>
  <form method="POST" name="DOIT2" action="">
    <input type="hidden" name="kpg_static_types_control" value="<?php echo $nonce;?>" />
    <table width="50%">
      <?php
	$r=0;
	foreach($options as $key=>$val) {
		if (substr($key,0,3)=='chk') {
			// we need to make an entry
			if ($r==0) echo "<tr>";
			$ext=substr($key,3);
			$checked='';
			if ($val=='Y') $checked=' checked="checked" ';
		?>
      <td width="25%"><input type="checkbox" <?php echo $checked; ?> value="Y" name="<?php echo $key; ?>" onclick="kpg_sp_click();">
          .<?php echo $ext; ?> </td>
        <?php
			$r++;
			if ($r==4) {
				echo "</tr>";
				$r=0;
			}
		}
	}	
	if ($r!=0) echo "</tr>";
		?>
    </table>
    <p><i>This plugin has been tested with the above file types, but some may require plugins or browser support.
      They may not work on all browsers or configurations. 
      Please test how they work on your site with your browser.<br/>
      Very large files will cause PHP to timeout in some installations and display an error or blank area.<br/>
      The plugin actually supports a large number of file types which are not listed here because they have not been tested. Search the code for the switch statement that looks at the file extensions to see if a file type will work. Most are not tested, so there is no guarantee that any will work. (See the faq section of the readme for a list of all the mime types this plugin might support.) </i></p>
    <p class="submit">
      <input class="button-primary" value="Update Types" type="submit">
    </p>
  </form>
  <div style="border:thin #D0D0D0 solid;padding:12px">
    <pre id="kpg_sp_htaccess">
</pre>
    <script type="text/javascript">
  kpg_sp_click();
</script>
  </div>
  <p>Copy the code above and paste into your .htaccess file(s). There one line for html, shtml and htm. You can delete the lines that don't apply. This only works for static files. It will not work with php, asp, cfm, jsp or other types of dynamically generated content.</p>
  <p style="color:#800000;font-weight:bold;">The plugin does not change your .htaccess file. You must manually edit the .htaccess file and deploy it to your server.</p>
  </fieldset>
  <h4>Options</h4>
  <form method="post" name="DOIT" action="">
    <input type="hidden" name="kpg_static_control" value="<?php echo $nonce;?>" />
    <fieldset style="border:solid thin #707070;width:80%;padding:8px;">
    <legend>Template file</legend>
    <input name="template" value="<?php echo $template;?>" />
    <br/>
    Normally this plugin will read your template's index file. If you have a file like single.php or a custom page template, you can place the name of the file here.
    </fieldset>
    <br/>
    <fieldset style="border:solid thin#707070;width:80%;padding:8px;">
    <legend>Comment Page</legend>
    <select name="id">
      <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
  	echo "<option ";
 	if ($id==$page->ID) echo " selected=\"selected\" ";
 	echo " value=\"". $page->ID . " \">";
	echo $page->post_title;
	echo "</option>";
  }
 ?>
    </select>
    <br/>
    The static pages are not in the WordPress database, so if you allow users to leave comments, you should direct those comments to a page. Select the page where you want comments to appear. <br/>
    It is best if you create a Static Page Comments "thank you" page, because after a user leaves a comment, they are directed to the real page.
    </fieldset>
	
    <fieldset style="border:solid thin #707070;width:80%;padding:8px;">
    <legend>Embeded File Dimensions</legend>
	<p>If you are embedding static pdf files, audio, or video, you need to enter the size of the box where they are displayed. Enter the numbr of pixels (no px or %)</p>
	<table>
	<tr><td>PDF display:</td><td>&nbsp;</td>
	<td>Width:&nbsp; <input name="pdfwidth" size="5" maxlength="4" value="<?php echo $pdfwidth;?>" /> pixels</td>
	<td>&nbsp;&nbsp;</td>
	<td>Height:&nbsp; <input name="pdfheight" size="5" maxlength="4" value="<?php echo $pdfheight;?>" /> pixels</td>
	</tr>
	<tr><td>Iframe display:</td><td>&nbsp;</td>
	<td>Width:&nbsp; <input name="ifwidth" size="5" maxlength="4" value="<?php echo $ifwidth;?>" /> pixels</td>
	<td>&nbsp;&nbsp;</td>
	<td>Height:&nbsp;<input name="ifheight" size="5" maxlength="4" value="<?php echo $ifheight;?>" /> pixels</td>
	</tr>
	<tr><td>Video display:</td><td>&nbsp;</td>
	<td>Width:&nbsp; <input name="vidwidth" size="5" maxlength="4" value="<?php echo $vidwidth;?>" /> pixels</td>
	<td>&nbsp;&nbsp; </td>
	<td>Height:&nbsp;<input name="vidheight" size="5" maxlength="4" value="<?php echo $vidheight;?>" /> pixels</td>
	</tr>
	<tr><td>Audio display:</td><td>&nbsp;</td>
	<td>Width:&nbsp; <input name="audiowidth" size="5" maxlength="4" value="<?php echo $audiowidth;?>" /> pixels</td>
	<td>&nbsp;&nbsp; </td>
	<td>Height:&nbsp; <input name="audioheight" size="5" maxlength="4" value="<?php echo $audioheight;?>" /> pixels</td>
	</tr>
	<tr><td>Default Object display:</td><td>&nbsp;</td>
	<td>Width:&nbsp; <input name="obwidth" size="5" maxlength="4" value="<?php echo $obwidth;?>" /> pixels</td>
	<td>&nbsp;&nbsp; </td>
	<td>Height:&nbsp; <input name="obheight" size="5" maxlength="4" value="<?php echo $obheight;?>" /> pixels</td>
	</tr>
	</table>
	
	
	
	
	
    </fieldset>
	
    <p class="submit">
      <input class="button-primary" value="Update" type="submit" onclick="return checkDOIT();">
    </p>
  </form>
  <script type="text/javascript">
	function checkDOIT() {
	    var fcheck=new Array()
		fcheck=[document.DOIT.pdfwidth,document.DOIT.pdfheight,document.DOIT.obwidth,document.DOIT.obheight,document.DOIT.ifwidth,document.DOIT.ifheight,document.DOIT.vidwidth,document.DOIT.vidheight,document.DOIT.audiowidth,document.DOIT.audioheight];
		// check the pixels to make sure they are numeric
		var j=0;
		
		for (j=0;j<fcheck.length;j++) {
			var chk=fcheck[j];
			if (!isNumberDOIT(chk.value)) {
				alert("Pixel count must be a number (no px or %)");
				chk.focus();
				return false;
			}
			if (chk.value<32||chk.value>5000) {
				alert("Pixel count must be a number from 32 to 5000");
				chk.focus();
				return false;
			}
		}
		return true;
	}
	function isNumberDOIT(n) {
	    try {
		return !isNaN(parseFloat(n)) && isFinite(n);
		} catch (e) {
			return false;
		}
	}

  </script
  <?php
	if (!empty($recent)) {
?>
  <h4>Recent Static Pages</h4>
  <form method="post" action="">
    <input type="hidden" name="kpg_static_recent_control" value="<?php echo $nonce;?>" />
    <p class="submit">
      <input class="button-primary" value="Delete Static History" type="submit">
    </p>
  </form>
  Link, Last Date, Count of Hits<br/>
  <?php
	foreach($recent as $lf=>$a) {
		$title=$a[0];
		$d=$a[1];
		$cnt=$a[2];
		?>
  <a href="<?php echo $lf; ?>" target="_blank"><?php echo $title;?></a>, &nbsp; <?php echo $d;?>, &nbsp; <?php echo $cnt;?>, <?php echo $lf; ?><br/>
  <?php
	}
}
?>
  <?php
     $f=dirname(__FILE__)."/static_debug_output.txt";
	 if (file_exists($f)) {
	    ?>
  <h3>Error Log</h3>
  <p>If debugging is turned on, the plugin will drop a record each time it encounters a PHP error. 
    Most of these errors are not fatal and do not effect the operation of the plugin. Almost all come from the unexpected data that
    spammers include in their effort to fool us. The author's goal is to eliminate any and
    all errors. These errors should be corrected. Fatal errors should be reported to the author at www.blogseye.com.</p>
  <form method="post" action="">
    <input type="hidden" name="kpg_static_log_control" value="<?php echo $nonce;?>" />
    <p class="submit">
      <input class="button-primary" value="Delete Error Log File" type="submit">
    </p>
  </form>
  <pre>
<?php readfile($f); ?>
</pre>
  <?php
	 }
?>
</div>
<?php
	// end of static-page-options.php
?>
