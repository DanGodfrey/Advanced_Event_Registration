<?php
//Build the header for the plugin
function admin_register_head(){ ?>
<link href="<?php echo EVNT_RGR_PLUGINFULLURL?>styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo EVNT_RGR_PLUGINFULLURL?>scripts/event_regis.js"></script>
<script type="text/javascript" src="<?php echo EVNT_RGR_PLUGINFULLURL?>scripts/fancybox/jquery.fancybox-1.2.5.pack.js"></script>
<script type="text/javascript">
	function myEdToolbar(obj) {
	   
		document.write("<img class=\"my_button\" src=\"<?php echo EVNT_RGR_PLUGINFULLURL?>images/paragraph.gif\" name=\"btnPara\" title=\"Paragraph\" onClick=\"doAddTags('<p>','</p>','" + obj + "')\">");
		document.write("<img class=\"my_button\" src=\"<?php echo EVNT_RGR_PLUGINFULLURL?>images/bold.gif\" name=\"btnBold\" title=\"Bold\" onClick=\"doAddTags('<strong>','</strong>','" + obj + "')\">");
		document.write("<img class=\"my_button\" src=\"<?php echo EVNT_RGR_PLUGINFULLURL?>images/italic.gif\" name=\"btnItalic\" title=\"Italic\" onClick=\"doAddTags('<em>','</em>','" + obj + "')\">");
		document.write("<img class=\"my_button\" src=\"<?php echo EVNT_RGR_PLUGINFULLURL?>images/underline.gif\" name=\"btnUnderline\" title=\"Underline\" onClick=\"doAddTags('<u>','</u>','" + obj + "')\">");
		document.write("<img class=\"my_button\" src=\"<?php echo EVNT_RGR_PLUGINFULLURL?>images/link.gif\" name=\"btnLink\" title=\"Insert Link\" onClick=\"doURL('" + obj + "')\">");
		document.write("<img class=\"my_button\" src=\"<?php echo EVNT_RGR_PLUGINFULLURL?>images/email.gif\" name=\"btnEmail\" title=\"Insert Email\" onClick=\"doMailto('" + obj + "')\">");
		document.write("<img class=\"my_button\" src=\"<?php echo EVNT_RGR_PLUGINFULLURL?>images/image.gif\" name=\"btnPicture\" title=\"Insert Picture\" onClick=\"doImage('" + obj + "')\" />");
		document.write("<img class=\"my_button\" src=\"<?php echo EVNT_RGR_PLUGINFULLURL?>images/ordered.gif\" name=\"btnList\" title=\"Ordered List\" onClick=\"doList('<ol>','</ol>','" + obj + "')\">");
		document.write("<img class=\"my_button\" src=\"<?php echo EVNT_RGR_PLUGINFULLURL?>images/unordered.gif\" name=\"btnList\" title=\"Unordered List\" onClick=\"doList('<ul>','</ul>','" + obj + "')\">");
		document.write("<img class=\"my_button\" src=\"<?php echo EVNT_RGR_PLUGINFULLURL?>images/list_item.gif\" name=\"btnList_Item\" title=\"List Item\" onClick=\"doAddTags('<li>','</li>','" + obj + "')\">");
		document.write("<img class=\"my_button\" src=\"<?php echo EVNT_RGR_PLUGINFULLURL?>images/quote.gif\" name=\"btnQuote\" title=\"Quote\" onClick=\"doAddTags('<blockquote>','</blockquote>','" + obj + "')\">"); 
	}

$j = jQuery.noConflict();
jQuery(document).ready(function($j) {
$j("a.ev_reg-fancylink").fancybox({
		'padding':		10,
		'imageScale':	true,
		'zoomSpeedIn':	250, 
		'zoomSpeedOut':	250,
		'zoomOpacity':	true, 
		'overlayShow':	false,
		'frameHeight':	250,
		'hideOnContentClick': false
	});
});
</script>
	
<?php 
}
?>
