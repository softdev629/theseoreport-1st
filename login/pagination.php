<style>
/* pagination style */
.pagin {
font-family:Verdana, Arial, Helvetica, sans-serif;
padding: 2px 0;
margin: 0;
font-family: "Verdana", sans-serif;
font-size: 7pt;
font-weight: bold;
}
.pagin * {
font-family:Verdana, Arial, Helvetica, sans-serif;
padding: 2px 6px;
margin: 0;
}
.pagin a {
font-family:Verdana, Arial, Helvetica, sans-serif;
border: solid 1px #666666;
background-color: #EFEFEF;
color: #666666;
text-decoration: none;
}
.pagin a:visited {
font-family:Verdana, Arial, Helvetica, sans-serif;
border: solid 1px #666666;
background-color: #EFEFEF;
color: #60606F;
text-decoration: none;
}
.pagin a:hover, .pagin a:active {
font-family:Verdana, Arial, Helvetica, sans-serif;
border: solid 1px #CC0000;
background-color: white;
color: #CC0000;
text-decoration: none;
}
.pagin span {
font-family:Verdana, Arial, Helvetica, sans-serif;
cursor: default;
border: solid 1px #808080;
background-color: #003366;
color: #B0B0B0;
}
.pagin span.current {
font-family:Verdana, Arial, Helvetica, sans-serif;
border: solid 1px #666666;
background-color:#003366;
color: white;
}
.pagination  {
    color: #32323a;
position: relative;
float: left;
padding: 6px 12px;
margin-left: -1px;
line-height: 1.42857143;
color: #337ab7;
text-decoration: none;
background-color: #fff;
border: 1px solid #ddd;
}
.pagination_n a {
    color: #32323a;
position: relative;
float: left;
padding: 6px 12px;
margin-left: -1px;
line-height: 1.42857143;
color: #337ab7;
text-decoration: none;
background-color: #fff;
border: 1px solid #ddd;
}


.pagination_n span {
padding: 5px 10px;
font-size: 12px;
line-height: 1.5;
}
.p_selected{
padding: 7px 11px !important;
background:#E9E9E9;
float:left;
border:1px solid #ddd;        
}
</style>

<?php
/*************************************************************************
php easy :: pagination scripts set - Version Three
==========================================================================
Author:      php easy code, www.phpeasycode.com
Web Site:    http://www.phpeasycode.com
Contact:     webmaster@phpeasycode.com
*************************************************************************/
function paginate_three($reload, $page, $tpages, $adjacents) {
	
	$prevlabel = "&lsaquo; &lsaquo;";
	$nextlabel = "&rsaquo; &rsaquo;";
	$out = "<div class=\"pagination_n\" >\n";
	
	// previous
	if($page==1) {
		//$out.= "<span>" . $prevlabel . "</span>\n";
	}
	elseif($page==2) {
		$out.= "<a href=\"" . $reload . "\">" . $prevlabel . "</a>\n";
	}
	else {
		$out.= "<a href=\"" . $reload . "&amp;page=" . ($page-1) . "\">" . $prevlabel . "</a>\n";
	}
	
	// first
	if($page>($adjacents+1)) {
		$out.= "<a href=\"" . $reload . "\">1</a>\n";
	}
	
	// interval
	if($page>($adjacents+2)) {
		$out.= "\n";
	}
	
	// pages
	$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
	$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
	for($i=$pmin; $i<=$pmax; $i++) {
		if($i==$page) {
			$out.= "<span class=\"pagination_n p_selected\">" . $i . "</span>\n";
		}
		elseif($i==1) {
			$out.= "<a href=\"" . $reload . "\">" . $i . "</a>\n";
		}
		else {
			$out.= "<a href=\"" . $reload . "&amp;page=" . $i . "\">" . $i . "</a>\n";
		}
	}
	
	// interval
	if($page<($tpages-$adjacents-1)) {
		$out.= "\n";
	}
	
	// last
	if($page<($tpages-$adjacents)) {
		$out.= "<a href=\"" . $reload . "&amp;page=" . $tpages . "\">" . $tpages . "</a>\n";
	}
	
	// next
	if($page<$tpages) {
		$out.= "<a href=\"" . $reload . "&amp;page=" . ($page+1) . "\">" . $nextlabel . "</a>\n";
	}
	else {
		//$out.= "<span>" . $nextlabel . "</span>\n";
	}
	
	$out.= "</div>";
	
	return $out;
}
?>