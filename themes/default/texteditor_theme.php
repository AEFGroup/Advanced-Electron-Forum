<?php

function editor_buttons($object = 'editor') {

    global $theme, $globals, $logged_in, $postcodefield, $error, $user, $smileys, $smileycode, $smileyimages, $smileyurl, $board, $dmenus, $onload;
    ?>
    <table cellpadding="0" cellspacing="0" height="22" style="margin-top:3px;">
        <tr valign="middle">

            <td class="bbcl"></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[b]', '[/b]');" href="javascript:void(0);" title="Bold"><img src="<?php echo $theme['images']; ?>bbc/bold.gif" alt="Bold" /></a></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[i]', '[/i]');" href="javascript:void(0);" title="Italics"><img src="<?php echo $theme['images']; ?>bbc/italics.gif" alt="Italics" /></a></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[u]', '[/u]');" href="javascript:void(0);" title="Underline"><img src="<?php echo $theme['images']; ?>bbc/underline.gif" alt="Underline" /></a></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[s]', '[/s]');" href="javascript:void(0);" title="Strike"><img src="<?php echo $theme['images']; ?>bbc/strikethrough.gif" alt="Strike" /></a></td>
            <td class="bbcr"></td>

            <td class="bbcem"></td>

            <td class="bbcl"></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[left]', '[/left]');" href="javascript:void(0);" title="Left Align"><img src="<?php echo $theme['images']; ?>bbc/left.gif" alt="Left Align" /></a></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[center]', '[/center]');" href="javascript:void(0);" title="Center Align"><img src="<?php echo $theme['images']; ?>bbc/center.gif" alt="Center Align" /></a></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[right]', '[/right]');" href="javascript:void(0);" title="Right Align"><img src="<?php echo $theme['images']; ?>bbc/right.gif" alt="Right Align" /></a></td>
            <td class="bbcr"></td>

            <td class="bbcem"></td>

            <td class="bbcl"></td>
            <td class="bbc" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'">&nbsp;<a href="javascript:void(0);" title="Font Size" onmouseover="dropmenu(this, 'fontsize')" onmouseout="pullmenu('fontsize')" >Font Size</a>&nbsp;</td>
            <?php
            $dmenus[] = '<table id="fontsize" onmouseover="clearTimeout(hider)" onmouseout="pullmenu(\'fontsize\')" class="ddopt" cellpadding="3" cellspacing="1">
<tr><td align="center">
<font size="1"><a href="javascript:' . $object . '.wrap_bbc(\'[size=1]\', \'[/size]\');">1</a></font>
</td></tr>
<tr><td align="center">
<font size="2"><a href="javascript:' . $object . '.wrap_bbc(\'[size=2]\', \'[/size]\');">2</a></font>
</td></tr>
<tr><td align="center">
<font size="3"><a href="javascript:' . $object . '.wrap_bbc(\'[size=3]\', \'[/size]\');">3</a></font>
</td></tr>
<tr><td align="center">
<font size="4"><a href="javascript:' . $object . '.wrap_bbc(\'[size=4]\', \'[/size]\');">4</a></font>
</td></tr>
<tr><td align="center">
<font size="5"><a href="javascript:' . $object . '.wrap_bbc(\'[size=5]\', \'[/size]\');">5</a></font>
</td></tr>
<tr><td align="center">
<font size="6"><a href="javascript:' . $object . '.wrap_bbc(\'[size=6]\', \'[/size]\');">6</a></font>
</td></tr>
<tr><td align="center">
<font size="7"><a href="javascript:' . $object . '.wrap_bbc(\'[size=7]\', \'[/size]\');">7</a></font>
</td></tr>
</table>';
            ?>

            <td class="bbc" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'">&nbsp;<a href="javascript:void(0);" title="Font Face" onmouseover="dropmenu(this, 'fontface')" onmouseout="pullmenu('fontface')">Font Faces</a>&nbsp;</td>
            <?php
            $dmenus[] = '<table id="fontface" onmouseover="clearTimeout(hider)" onmouseout="pullmenu(\'fontface\')" class="ddopt" cellpadding="3" cellspacing="1">

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="arial"><a href="javascript:' . $object . '.wrap_bbc(\'[font=arial]\', \'[/font]\');">Arial</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="Arial Black"><a href="javascript:' . $object . '.wrap_bbc(\'[font=Arial Black]\', \'[/font]\');">Arial Black</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="Arial Narrow"><a href="javascript:' . $object . '.wrap_bbc(\'[font=Arial Narrow]\', \'[/font]\');">Arial Narrow</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="Courier"><a href="javascript:' . $object . '.wrap_bbc(\'[font=Courier]\', \'[/font]\');">Courier</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="courier new"><a href="javascript:' . $object . '.wrap_bbc(\'[font=courier new]\', \'[/font]\');">Courier New</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="geneva"><a href="javascript:' . $object . '.wrap_bbc(\'[font=geneva]\', \'[/font]\');">Geneva</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="georgia"><a href="javascript:' . $object . '.wrap_bbc(\'[font=georgia]\', \'[/font]\');">Georgia</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="helvetica"><a href="javascript:' . $object . '.wrap_bbc(\'[font=helvetica]\', \'[/font]\');">Helvetica</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="monospace"><a href="javascript:' . $object . '.wrap_bbc(\'[font=monospace]\', \'[/font]\');">Monospace</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="serif"><a href="javascript:' . $object . '.wrap_bbc(\'[font=serif]\', \'[/font]\');">Serif</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="Times New Roman"><a href="javascript:' . $object . '.wrap_bbc(\'[font=Times New Roman]\', \'[/font]\');">Times New Roman</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="Tahoma"><a href="javascript:' . $object . '.wrap_bbc(\'[font=Tahoma]\', \'[/font]\');">Tahoma</a></font>
</td></tr>

<tr><td class="bbcddm" onmouseover="this.className=\'bbcddmon\'" onmouseout="this.className=\'bbcddm\'">
<font face="verdana"><a href="javascript:' . $object . '.wrap_bbc(\'[font=verdana]\', \'[/font]\');">Verdana</a></font>
</td></tr>

</table>';
            ?>
            <td class="bbc" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'">&nbsp;<a href="javascript:void(0);" title="Text Color" onmouseover="dropmenu(this, 'color')" onmouseout="pullmenu('color')">Color</a>&nbsp;</td>
            <?php
            $dmenus[] = '<table id="color" onmouseover="clearTimeout(hider)" onmouseout="pullmenu(\'color\')" class="ddopt" cellpadding="3" cellspacing="0">

<tr>
<td colspan="10" style="background:#DDE7EE">
<b>Standard Colors</b>
</td>
</tr>

<tr>
<td>
<table border="0" cellpadding="0" cellspacing="3" class="ctddm">
<tr>
<td style="background:#BF0000;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#BF0000]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#FF0000;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#FF0000]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#FFC000;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#FFC000]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#FFFF00;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#FFFF00]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#92D050;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#92D050]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#00B050;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#00B050]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#00B0F0;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#00B0F0]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#0070C0;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#0070C0]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#002060;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#002060]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#7030A0;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#7030A0]\', \'[/color]\');"><div>&nbsp;</div></a></td>
</tr>
</table>

</td>
</tr>

<tr>
<td colspan="10" style="background:#DDE7EE">
<b>Theme Colors</b>
</td>
</tr>

<tr>
<td>
<table border="0" cellpadding="0" cellspacing="3" class="ctddm">
<tr>
<td style="background:#FFFFFF;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#FFFFFF]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#040404;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#040404]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#EEECE1;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#EEECE1]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#1F497D;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#1F497D]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#4F81BD;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#4F81BD]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#C0504D;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#C0504D]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#9BBB59;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#9BBB59]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#8064A2;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#8064A2]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#4BACC6;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#4BACC6]\', \'[/color]\');"><div>&nbsp;</div></a></td>
<td style="background:#F79646;"><a href="javascript:' . $object . '.wrap_bbc(\'[color=#F79646]\', \'[/color]\');"><div>&nbsp;</div></a></td>
</tr>
</table>

</td>
</tr>

</table>';
            ?>
            <td class="bbcr"></td>

            <td class="bbcem"></td>

            <td class="bbcl"></td>

            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.toggle();" href="javascript:void(0);" title="Toggle Mode"><img src="<?php echo $theme['images']; ?>bbc/toggle.gif" alt="Toggle Mode" /></a></td>
            <td class="bbcr"></td>

        </tr>

    </table>

    <table cellpadding="0" cellspacing="0" height="22" style="margin-top:3px; margin-bottom:3px;">
        <tr valign="middle">

            <td class="bbcl"></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a href="javascript:url();" title="Anchor Link"><img src="<?php echo $theme['images']; ?>bbc/hyperlink.gif" alt="Anchor Link" /></a></td><?php $dmenus[] = '<div id="url" class="lpb">

<table width="100%" cellspacing="0" cellpadding="0" id="urlhandle" >
<tr>
<td class="dwhl"></td>
<td align="left" class="dwhc"><b>Anchor Link</b></td>
<td align="right" class="dwhc"><a href="javascript:hideel(\'url\')"><img src="' . $theme['images'] . 'close.gif"></a></td>
<td class="dwhr"></td>
</tr>
</table>

<table width="100%" cellspacing="1" cellpadding="2" class="dwbody">
<tr>
<td class="rlc" width="15%"><b>URL : </b></td>
<td align="left" class="rrc">
<input type="text" name="linkurl" size="30" id="linkurl">
</td>
</tr>

<tr>
<td class="rlc" width="15%"><b>Text : </b></td>
<td align="left" class="rrc">
<input type="text" name="urltext" size="30" id="urltext">
</td>
</tr>

<tr>
<td class="rlc" colspan="2" style="text-align:center">
<input type="button" name="submitpost" value="OK" onclick="javascript:makeurl();hideel(\'url\');"/>
</td>
</tr>

<tr>
<td align="left" class="dwb" colspan="2"></td>
</tr>

</table>
</div>
<script type="text/javascript">
Drag.init($(\'urlhandle\'), $(\'url\'));
function url(){	
	if(' . $object . '.on){
		var linkurl = prompt("Enter the URL", "http://");
		' . $object . '.insertlink(linkurl);
		return;
	}
	$(\'urltext\').value = "";
	$(\'linkurl\').value = "";
	urlid = \'url\';
	$(urlid).style.left=((getwidth()/2)-($(urlid).offsetWidth/2))+"px";
	$(urlid).style.top=(scrolledy()+110)+"px";
	showel(urlid);
	smoothopaque(urlid, 0, 100, 10);
}
</script>
'; ?>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a href="javascript:ftp();" title="FTP Link"><img src="<?php echo $theme['images']; ?>bbc/ftp.gif" alt="FTP Link" /></a></td><?php $dmenus[] = '<div id="ftp" class="lpb">

<table width="100%" cellspacing="0" cellpadding="0" id="ftphandle" >
<tr>
<td class="dwhl"></td>
<td align="left" class="dwhc"><b>FTP Link</b></td>
<td align="right" class="dwhc"><a href="javascript:hideel(\'ftp\')"><img src="' . $theme['images'] . 'close.gif"></a></td>
<td class="dwhr"></td>
</tr>
</table>

<table width="100%" cellspacing="1" cellpadding="2" class="dwbody">
<tr>
<td class="rlc" width="15%"><b>URL : </b></td>
<td align="left" class="rrc">
<input type="text" name="ftplink" size="30" id="ftplink">
</td>
</tr>

<tr>
<td class="rlc" width="15%"><b>Text : </b></td>
<td align="left" class="rrc">
<input type="text" name="ftptext" size="30" id="ftptext">
</td>
</tr>

<tr>
<td class="rlc" colspan="2" style="text-align:center">
<input type="button" name="submitpost" value="OK" onclick="javascript:makeftp();hideel(\'ftp\');"/>
</td>
</tr>

<tr>
<td align="left" class="dwb" colspan="2"></td>
</tr>

</table>
</div>
<script type="text/javascript">
Drag.init($(\'ftphandle\'), $(\'ftp\'));
function ftp(){
	if(' . $object . '.on){
		var ftpurl = prompt("Enter the FTP URL", "ftp://");
		' . $object . '.insertlink(ftpurl);
		return;
	}
	$(\'ftptext\').value = "";
	$(\'ftplink\').value = "";
	ftpid = \'ftp\';
	$(ftpid).style.left=((getwidth()/2)-($(ftpid).offsetWidth/2))+"px";
	$(ftpid).style.top=(scrolledy()+110)+"px";
	showel(ftpid);
	smoothopaque(ftpid, 0, 100, 10);
}
</script>
'; ?>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a href="javascript:email();" title="Email Link"><img src="<?php echo $theme['images']; ?>bbc/email.png" alt="Email Link" /></a></td><?php $dmenus[] = '<div id="email" class="lpb">

<table width="100%" cellspacing="0" cellpadding="0" id="emailhandle" >
<tr>
<td class="dwhl"></td>
<td align="left" class="dwhc"><b>Email Link</b></td>
<td align="right" class="dwhc"><a href="javascript:hideel(\'email\')"><img src="' . $theme['images'] . 'close.gif"></a></td>
<td class="dwhr"></td>
</tr>
</table>

<table width="100%" cellspacing="1" cellpadding="2" class="dwbody">
<tr>
<td class="rlc" width="15%"><b>Address : </b></td>
<td align="left" class="rrc">
<input type="text" name="emailadd" size="26" id="emailadd">
</td>
</tr>

<tr>
<td class="rlc" width="15%"><b>Addressee : </b></td>
<td align="left" class="rrc">
<input type="text" name="addressee" size="26" id="addressee">
</td>
</tr>

<tr>
<td class="rlc" colspan="2" style="text-align:center">
<input type="button" name="submitpost" value="OK" onclick="javascript:makeemail();hideel(\'email\');"/>
</td>
</tr>

<tr>
<td align="left" class="dwb" colspan="2"></td>
</tr>

</table>
</div>
<script type="text/javascript">
Drag.init($(\'emailhandle\'), $(\'email\'));
function email(){
	if(' . $object . '.on){
		var emailadd = prompt("Enter the email address", "");
		if(emailadd){
			' . $object . '.insertlink("mailto:"+emailadd);
		}
		return;
	}
	$(\'addressee\').value = "";
	$(\'emailadd\').value = "";
	emailid = \'email\';
	$(emailid).style.left=((getwidth()/2)-($(emailid).offsetWidth/2))+"px";
	$(emailid).style.top=(scrolledy()+110)+"px";
	showel(emailid);
	smoothopaque(emailid, 0, 100, 10);
}
</script>
'; ?>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[img]', '[/img]');" href="javascript:void(0);" title="Inline Image"><img src="<?php echo $theme['images']; ?>bbc/image.gif" alt="Inline Image" /></a></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[flash=200,200]', '[/flash]');" href="javascript:void(0);" title="Flash"><img src="<?php echo $theme['images']; ?>bbc/flash.gif" alt="Flash" /></a></td>

            <td class="bbcr"></td>

            <td class="bbcem"></td>

            <td class="bbcl"></td>

            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[ol]\n[li][/li]\n', '[li][/li]\n[/ol]');" href="javascript:void(0);" title="Ordered Lists"><img src="<?php echo $theme['images']; ?>bbc/ol.gif" alt="Ordered Lists" /></a></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[ul]\n[li][/li]\n', '[li][/li]\n[/ul]');" href="javascript:void(0);" title="Unordered Lists"><img src="<?php echo $theme['images']; ?>bbc/ul.gif" alt="Unordered Lists" /></a></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[li]', '[/li]\n');" href="javascript:void(0);" title="Insert List"><img src="<?php echo $theme['images']; ?>bbc/list.gif" alt="Insert List" /></a></td>

            <td class="bbcr"></td>

            <td class="bbcem"></td>

            <td class="bbcl"></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[sup]', '[/sup]');" href="javascript:void(0);" title="Superscript Text"><img src="<?php echo $theme['images']; ?>bbc/sup.gif" alt="Superscript Text" /></a></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[sub]', '[/sub]');" href="javascript:void(0);" title="Subscript Text"><img src="<?php echo $theme['images']; ?>bbc/sub.gif" alt="Subscript Text" /></a></td>
            <td class="bbcr"></td>

            <td class="bbcem"></td>

            <td class="bbcl"></td>

            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[hr]', '');" href="javascript:void(0);" title="Horizontal Rule"><img src="<?php echo $theme['images']; ?>bbc/hr.gif" alt="Horizontal Rule" /></a></td>
            <td class="bbcr"></td>


            <td class="bbcem"></td>

            <td class="bbcl"></td>

            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[quote]', '[/quote]');" href="javascript:void(0);" title="Quote Text"><img src="<?php echo $theme['images']; ?>bbc/quote.png" alt="Quote Text" /></a></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[code]', '[/code]');" href="javascript:void(0);" title="Wrap Code"><b>#</b></a></td>
            <td class="bbc" width="22" onmouseover="this.className='bbcon'" onmouseout="this.className='bbc'"><a onclick="javascript:<?php echo $object; ?>.wrap_bbc('[php]', '[/php]');" href="javascript:void(0);" title="PHP Code">php</a></td>

            <td class="bbcr"></td>


        </tr>

    </table>
    <?php
}

function editor_smileys($object = 'editor', $showsmileys) {

    global $theme, $globals, $smileys, $smileycode, $smileyimages, $smileyurl, $dmenus;

    if ($showsmileys && !empty($smileys)) {

        $js_smileys = array();

        $emoticons = array();

        //Now these are purely for JavaScript Processing
        foreach ($smileys as $sk => $sv) {

            $js_smileys[] = 'new Array(\'' . addslashes(preg_quote($sv['smcode'], '/')) . '\', \'' . addslashes($sv['smcode']) . '\', \'' . $smileyurl[$sk] . '\')';
        }

        echo '<script type="text/javascript">
		aefsmileys = new Array(' . implode(',', $js_smileys) . ');
		</script>';

        //Now these are purely for JavaScript Processing
        foreach ($smileys as $sk => $sv) {

            if (!($smileys[$sk]['smstatus'])) {

                $emoticons[] = '<a onclick="javascript:' . $object . '.insertemot_code(\'' . $smileycode[$sk] . '\', \'' . $smileyurl[$sk] . '\');" href="javascript:void(0)">' . trim($smileyimages[$sk]) . '</a>';

                //It is to be in the pop up
            } else {

                $popup_emoticons[] = '<a onclick="javascript:' . $object . '.insertemot_code(\'' . $smileycode[$sk] . '\', \'' . $smileyurl[$sk] . '\');" href="javascript:void(0)">' . trim($smileyimages[$sk]) . '</a>';
            }
        }

        echo '<tr>
			<td width="18%" class="ntlc">Smileys</td>
			<td class="ntrc">';

        echo implode('&nbsp;', $emoticons);

        if (!empty($popup_emoticons)) {

            echo '&nbsp;<a href="javascript:popupemot();">......</a>';

            $dmenus[] = '<div id="popupemot" class="lpb">
<table width="100%" cellspacing="0" cellpadding="0" id="popupemothandle" >
<tr>
<td class="dwhl"></td>
<td align="left" class="dwhc"><b>Emoticons</b></td>
<td align="right" class="dwhc"><a href="javascript:hideel(\'popupemot\')"><img src="' . $theme['images'] . 'close.gif"></a></td>
<td class="dwhr"></td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" class="dwbody">
<tr>
<td class="llc">' . implode(' ', $popup_emoticons) . '</td>
</tr>
</table>

</div>

<script type="text/javascript">
Drag.init($(\'popupemothandle\'), $(\'popupemot\'));
function popupemot(){
	var winid = \'popupemot\';
	$(winid).style.left=((getwidth()/2)-($(winid).offsetWidth/2))+"px";
	$(winid).style.top=(scrolledy()+110)+"px";
	showel(winid);
	smoothopaque(winid, 0, 100, 10);
}
</script>';
        }

        echo '</td>
			</tr>';
    }
}
?>