<?php
/*
	File: visualcube.php
	Date: 02 Apr 2010
	Author(s): Conrad Rider (www.crider.co.uk)
	Description: Main script to generate cube images

	This file is part of VisualCube.

	VisualCube is free software: you can redistribute it and/or modify
	it under the terms of the GNU Lesser General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	VisualCube is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Lesser General Public License for more details.

	You should have received a copy of the GNU Lesser General Public License
	along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
	
	Copyright (C) 2010 Conrad Rider
	
	TODO:
	* Model for NxNxN cubes
	* Display plan view example on main page
*/

	// Causes cube svg to be outputted as XML for inspection
	$DEBUG = false;

	// Database Configuration (for image caching)
	
	$DB_NAME="DATABASE_NAME";
	$DB_USERNAME="DATABASE_USERNAME";
	$DB_PASSWORD="DATABASE_PASSWORD";

	// Whether image caching is enabled. NOTE: if enabled a cron
	// job will need to be set up to prun the database
	$ENABLE_CACHE = true; 
	// Maximum size of image to be cached
	$CACHE_IMG_SIZE_LIMIT = 10000; // 10Kb
	
	// If no format specified, display API page
	if(!array_key_exists('fmt', $_REQUEST)){
		// XML definition
		$HTML_DEF = '<?xml version="1.0" encoding="iso-8859-1"?>'."\n".
		    '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"'."\n".
		    '   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n";

		// Start page render
		echo $HTML_DEF;
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>VisualCube (v0.3.1)</title>
		<meta name="description"        content="Rubiks cube visualiser"/>
		<meta name="keywords"           content="visualcube, visual cube, imagecube, image cube, cube vis, viscube, visual rubiks, imgcube, cube image, cube gif, cub png, cube jpeg"/>
		<meta name="resource-type"      content="document"/>
		<meta name="language"           content="English"/>
		<meta name="rating"             content="general"/>
		<meta name="robots"             content="all"/>
		<meta name="expires"            content="never"/>
		<meta name="revisit-after"      content="14 days"/>
		<meta name="distribution"       content="global"/>
		<meta name="author"             content="Conrad Rider"/>
		<meta name="copyright"          content="Copyright © 2009-2010 Conrad Rider"/>
		<meta http-equiv="Content-Type" content="text/html; iso-8859-1"/>
		<style media="screen" type="text/css">
			@import url("screen.css");
			table{
				border-spacing:0px; 
				border-top:1px solid silver;
				border-left:1px solid silver;
				border-right:0;
				border-bottom:1px solid silver;
				background-color:#FAFAFA; 
				
			}
			th{
				background-color:#DDDDDD; 
				border-right:1px solid silver;
				text-align:center;
			}
			h2{
				margin-top:10px;
			}
			td{
				vertical-align:top;
				border-top:1px solid grey; 
				border-right: 1px solid silver;
				padding:10px;
			}
			em{
				font-style:normal;
				font-weight:bold;
			}
			#examples img{
				border:0;
				float:none;
			}
			#content_v{
				margin:10px 50px;
				text-align:left;
			}
			#header_v{
				margin:10px 50px;
				text-align:left;
				
			}
			#header_v img{
				float:right;
				border:none;
			}
		</style>
	</head>
	<body>
		<div id="header_v">
			<a href="http://validator.w3.org/check?uri=referer" title="Valid XHTML 1.0 Strict">
				<img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" width="88" height="31" style="margin-right:20px"/>
			</a>
			<h1>VisualCube</h1>
			Generate custom Rubik's cube visualisations from your browser address bar.
			<br/><br/>
		</div>
		<div id="content_v">
			<h2>Instructions</h2>
			Simply point your browser to visualcube.png to create a cube image.<br/>
			A range of parameters can be set to customise the cube visualisation.<br/>
			Click the link below for an example:<br/><br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="visualcube.png?size=150&amp;pzl=2&amp;alg=R2F2R2">cube.crider.co.uk/visualcube.png?size=150&amp;pzl=2&amp;alg=R2F2R2</a>
			<br/><br/><br/>
			<h2>Examples</h2>
			The following images were generated by VisualCube.
			<br/><br/>
			<div id="examples">
				<a href="visualcube.png?size=200&amp;alg=S2M2E2">
					<img src="visualcube_0.gif" alt="Example 0"/></a>
				<a href="visualcube.png?size=200&amp;cc=s&amp;sch=yrbnog&amp;fd=fdduufdrubulurbflrlfrbfruldlfrddbfddlbfulrrlbbludblbfu">
					<img src="visualcube_1.gif" alt="Example 1"/></a>
				<a href="visualcube.png?size=200&amp;co=30&amp;co=12&amp;fo=50">
					<img src="visualcube_2.gif" alt="Example 2"/></a>
				<a href="visualcube.png?size=200&amp;r=y45x34&amp;cc=n&amp;fo=100&amp;co=35&amp;fd=tototototttttttttttttofotfttdtodotdtttttttttttttobotbt">
					<img src="visualcube_3.gif" alt="Example3"/></a>
				<a href="visualcube.png?size=200&amp;pzl=7&amp;r=z-15x-105&amp;sch=yyyyyy&amp;fc=ynyyynynnnynnnyyyyyyyyynnnyynyynyynnnyyynnynnnnny">
					<img src="visualcube_4.gif" alt="Example4"/></a>
			</div>
			Click each cube to see how it was generated..
			<br/><br/><br/>
			<h2>Features</h2>
			<ul>
				<li>Fully 3D cube visualisation</li>
				<li>Cube dimensions from 1x1x1 to 9x9x9</li>
				<li>Algorithm support</li>
				<li>Complete orientation control</li>
				<li>Multiple image formats</li>
				<li>Custom image size</li>
				<li>Cube and facelet transparency</li>
				<li>Custom colour schemes</li>
				<li>Custom background colour</li>
				<li>Image caching for speedy access</li>
			</ul>
			<br/>
			<h2>To Do</h2>
			<div>
				The following features/bug fixes are planned for the future (ordered by priority).
				<ul>
					<li>Stage mask to be applied before algorithm execution</li>
					<li>More stage values inc eo, eoline, f2b, cls, els, zbll, cll, ell, oll, pll</li>
					<li>More special views added to the 'view' variable (permutation arrows for example)</li>
					<li>Algorithms for 4x4 cubes and above</li>
					<li>Visualisation of other puzzles</li>
				
				</ul>
				<br/><br/>
			</div>
			<h2>Source Code</h2>
			<div> The source code for this script is available under the GNU Lesser General Public License at
			<a href="https://sourceforge.net/projects/vcube/">sourceforge.net/projects/vcube</a>.</div>
			<br/><br/>
			<h2>Parameters</h2>
			<table>
				<tr><th>Variable</th><th>Description</th><th>Value Range</th><th>Default</th><th>Comment</th></tr>
				<tr><td><em>.</em></td><td>script extension</td><td> .png | .gif | .jpg | .svg | .tiff | .ico </td><td>.png</td>
					<td>The extension used in the script url dictates the format of the image generated. For example:
					visiting <a href="visualcube.jpg">/visualcube.jpg</a>
					will create a jpeg image.</td></tr>
				<tr><td><em>fmt</em></td><td>Image Format</td><td> png | gif | jpg | svg | tiff | ico </td><td>.png</td>
					<td>Used as an alternative to using an image extension as above.</td></tr>
				<tr><td><em>pzl</em></td><td>Puzzle Type</td><td>1 to 9</td><td>3</td>
					<td>Values from N=(1 to 9) represent an NxNxN cube. Currently only regular cubes are modelled</td></tr>
				<tr><td><em>size</em></td><td>Size of generated image</td><td>0 to 1024</td><td>128</td><td>
					Images produced are square, so size specifies both width and height of the final image in pixels.</td></tr>
				<tr><td><em>view</em></td><td>Special View</td><td>plan|trans</td><td>&nbsp;</td>
					<td>The view parameter allows special views to facilitate interpretation of different case aspects.
					<br/><em>plan</em> rotates cube to expose U face, while showing the sides of the top layer<br/>
					<em>trans</em> sets the cube base colour to transparent, and hides any masked or undefined faces</td></tr>
				<tr><td><em>stage</em></td><td>Stage Mask</td><td>fl | f2l | ll | cll | ell | oll | coll | ocell</td><td>&nbsp;</td>
					<td>Sets parts of the cube to be masked from being coloured.</td></tr>
				<tr><td><em>r</em></td><td>Rotation Sequence</td><td>([xyz]-?[0-9][0-9]?[0-9]?)+</td><td>y45x-34</td>
					<td>Each entry in the sequence is an axis (x, y or z), followed by the
					number of degrees to rotate in a clockwise direction. Negative values are permitted.
					Any number of rotations is possible.</td></tr>
				<tr><th colspan="5">State Definitions</th></tr>
				<tr><td><em>alg</em></td><td>Algorithm to apply</td><td>[UDLRFBudlrfbMESxyz'2 ]*</td><td>&nbsp;</td>
					<td>The system applies the algorithm to the cube and displays the resulting state.<br/><br/>
					<em>NOTE:</em> Currently unavailable for 4x4 cubes or above</td></tr>
				<tr><td><em>case</em></td><td>Algorithm to solve case</td><td>[UDLRFBudlrfbMESxyz'2 ]*</td><td>&nbsp;</td>
					<td>The system displays the cube state which is solved by applying the algorithm
					(algorithm inverse).<br/><br/>
					<em>NOTE:</em> Currently unavailable for 4x4 cubes or above</td></tr>
				<tr><td><em>fd</em></td><td>Facelet Definition</td><td>[udlrfbnot]*</td>
					<td>uuuuuuuuu rrrrrrrrr fffffffff ddddddddd lllllllll bbbbbbbbb</td>
					<td>Defines the cube state in terms of facelet positions.
					u stands for a 'U' facelet (and likewise with rfdlb).
					Defining a cube state using this method means the cube will be coloured
					according to the scheme defined by the <em>sch</em> variable.
					Three special characters are used to indicate the following:<br/>
					<em>n</em>: This is a blank face (coloured grey)<br/>
					<em>o</em>: This is an 'oriented' face (coloured silver)<br/>
					<em>t</em>: This is a transparent face, and will not appear on the cube
					</td></tr>
				<tr><td><em>fc</em></td><td>Facelet Colours</td><td>[ndlswyrobgmpt]*</td>
					<td>yyyyyyyyy rrrrrrrrr bbbbbbbbb wwwwwwwww ooooooooo ggggggggg</td>
					<td>Defines the cube state in terms of facelet colours,
					as an alternative to using fd. fc
					takes precedence over fd if both are defined.<br/><br/>
					See the 'sch' variable below for an explanation of the colour codes.
					</td></tr>
				<tr><th colspan="5">Cube Style</th></tr>
				<tr><td><em>sch</em></td><td>Colour Scheme</td>
					<td>[ndlswyrobgmp]*6 <br/><br/>OR<br/><br/>
					Comma separated list containing 6x one of:<br/>
					black | dgrey | grey | silver | white | yellow | red | orange | blue
					| green | purple | pink | [0-9a-fA-F]*3 | [0-9a-fA-F]*6
					</td><td>yrbwog</td>
					<td>The order of the colours specified represent the faces in this order:<br/><br/>
					U R F D L B
					<br/><br/>The letters used in shorthand notation map to the generic
					face colours as follows: n=black (noir), d=dark grey, l=light grey,
					s=silver (lighter grey), w=white, y=yellow, r=red, o=orange, b=blue, g=green,
					m=purple (magenta), p=pink, t=transparent<br/><br/>
					Where longhand notation is used, 3 or 6-digit hex codes can be used to specify
					the exact colour. for example C80000 would be a dark red colour.
					</td></tr>
				<tr><td><em>bg</em></td><td>Background Colour of image</td><td>[ndlswyrobgmpt] <br/><br/>OR<br/><br/>
					black | dgrey | grey | silver | white | yellow | red | orange | blue
					| green | purple | pink | [0-9a-fA-F]*3 | [0-9a-fA-F]*6
					</td>
					<td>FFF</td><td>The value <em>t</em> represents transparent, and is only valid for png and gif images.</td></tr>
				<tr><td><em>cc</em></td><td>Cube Colour</td><td>see above</td><td>black</td><td>This is the cube's base colour.</td></tr>
				<tr><td><em>co</em></td><td>Cube Opacity</td><td>0 to 99</td><td>100</td>
					<td>Setting this value causes the base cube to be transparent.
					It means facelets at the back of the cube will also be rendered.
					A value of 0 gives complete transparency.</td></tr>
				<tr><td><em>fo</em></td><td>Facelet Opacity</td><td>0 to 99</td><td>100</td>
					<td>Setting this value causes the facelets to be rendered with transparency.</td></tr>
			</table>
			<br/><br/>
		</div>
		<div id="footer">
			Copyright &copy; 2010 <a href="http://www.crider.co.uk">Conrad Rider</a>.
			<br/>Cube images generated by VisualCube are free to copy and distribute
		</div>
	</body>
</html>
<?	
	}else{
	
		// Check cache for image and return if it exists in cache
		if($ENABLE_CACHE){
			// Connect to db
			mysql_connect("localhost", $DB_USERNAME, $DB_PASSWORD);
			@mysql_select_db($DB_NAME) or die("Unable to select database");

			$hash = md5($_SERVER['QUERY_STRING']);
			$imgdata = get_arrays("SELECT fmt, req, rcount, img FROM vcache WHERE hash='$hash'");
			// Verify query strings are equal (deals with unlikely, but possible hash collisions)
			if(count($imgdata) > 0 && $imgdata[0]['req'] == $_SERVER['QUERY_STRING']){
				display_img($imgdata[0]['img'], $imgdata[0]['fmt']);
				// Increment access count
				mysql_query("UPDATE vcache SET rcount=".($imgdata[0]['rcount'] + 1)." WHERE hash='$hash'");
				// Disconnect from db
				mysql_close();
				return;
			}
		}
		
		
		// Otherwise generate image

		// -----------------[ Constants ]-----------------
	
		// Faces
		$U = 0; $R = 1; $F = 2; $D = 3; $L = 4; $B = 5; $N = 6; $O = 7; $T = 8;

	
		// Colour constants
		$BLACK  = '000000';
		$DGREY  = '404040';
		$GREY   = '808080';
		$SILVER = 'BFBFBF';
		$WHITE  = 'FFFFFF';
		$YELLOW = 'FEFE00';
		$RED    = 'FE0000';
		$ORANGE = 'FE8600';
		$BLUE   = '0000F2';
		$GREEN  = '00F300';
		$PURPLE = 'A83DD9';
		$PINK   = 'F33D7B';
	
		// Other colour schemes
		// Array('FFFF00', 'FF0000', '0000FF', 'FFFFFF', 'FF7F00', '00FF00'); // Basic
		// Array('EFEF00', 'C80000', '0000B6', 'F7F7F7', 'FFA100', '00B648'); // Cubestation
		// Array('EFFF01', 'FF0000', '1600FF', 'FEFFFC', 'FF8000', '047F01'); // cube.rider
		// Array('FEFE00', 'FE0000', '0000F2', 'FEFEFE', 'FE8600', '00F300'); // alg.garron

		// Name colour mapping
		$NAME_COL = Array(
			'black'  => $BLACK,
			'dgrey'  => $DGREY,
			'grey'   => $GREY,
			'silver' => $SILVER,
			'white'  => $WHITE,
			'yellow' => $YELLOW,
			'red'    => $RED,
			'orange' => $ORANGE,
			'blue'   => $BLUE,
			'green'  => $GREEN,
			'purple' => $PURPLE,
			'pink'   => $PINK);
		
		// Abbriviation colour mapping
		$ABBR_COL = Array(
			'n' => $BLACK,
			'd' => $DGREY,
			'l' => $GREY,
			's' => $SILVER,
			'w' => $WHITE,
			'y' => $YELLOW,
			'r' => $RED,
			'o' => $ORANGE,
			'b' => $BLUE,
			'g' => $GREEN,
			'm' => $PURPLE,
			'p' => $PINK,
			't' => 't'); // Transparent

		// Default colour scheme
		$DEF_SCHEME = Array( $YELLOW, $RED, $BLUE, $WHITE,  $dim == 2 ? $PINK : $ORANGE, $GREEN, $GREY, $SILVER, 't');

		// -----------------------[ User Parameters ]--------------------

		// Retrive format from user, default to first in list otherwise
		$LEGAL_FMT = Array ('gif', 'png', 'svg', 'jpg', 'jpeg', 'tiff', 'ico');
		$fmt = $LEGAL_FMT[0];
		if(array_key_exists('fmt', $_REQUEST)){
			$fmt = $_REQUEST['fmt'];
			if(!in_array($fmt, $LEGAL_FMT))
				$fmt = $LEGAL_FMT[0];
			else{
				if($fmt == 'jpeg') $fmt = 'jpg';
			}
		}
	
		// Default rotation sequence
		$rtn = Array(Array(1, 45), Array(0, -34));
		// Get rotation from user
		if(array_key_exists('r', $_REQUEST)){
			preg_match_all('/([xyz])(\-?[0-9][0-9]?[0-9]?)/', $_REQUEST['r'], $matches);
			for($i = 0; $i < count($matches[0]); $i++){
				switch($matches[1][$i]){
					case 'x' : $rtn_[$i][0] = 0; break;
					case 'y' : $rtn_[$i][0] = 1; break;
					case 'z' : $rtn_[$i][0] = 2; break;
					default : continue;
				}
				$rtn_[$i][1] = $matches[2][$i];
			}
			if($rtn_) $rtn = $rtn_;
		}

		// Retrive cube Dimension
		$dim = 3;
		if(array_key_exists('pzl', $_REQUEST)
		&& preg_match('/^[1-9]$/', $_REQUEST['pzl']))
			$dim = $_REQUEST['pzl'];
		
		// Default scheme
		$scheme = $DEF_SCHEME;
		
		// Default mapping from colour code to face id
		$schcode = Array('y', 'r', 'b', 'w', 'o', 'g',);
		
		// Retrive colour scheme from user
		if(array_key_exists('sch', $_REQUEST)){
			$sd = $_REQUEST['sch'];
			if(preg_match('/^[ndlswyrogbpmt]{6}$/', $sd)){
				for($i = 0; $i < 6; $i++){
					$scheme[$i] = $ABBR_COL[$sd[$i]];
					$schcode[$i] = $sd[$i];
				}
			}
			else{
				$cols = preg_split('/,/', $sd);
				if(count($cols) == 6){
					$cok = true;
					for($i = 0; $i < 6; $i++){
						$scheme[$i] = parse_col($cols[$i]);
						if(!$cols[$i]) $cok = false;
					}
					if(!$cok) $scheme = $DEF_SCHEME;
				}
			}
		}

		// Retrive size from user
		$size = 128; // default
		if(array_key_exists('size', $_REQUEST) && is_numeric($_REQUEST['size'])){
			$size = $_REQUEST['size'];
			if($size < 0) $size = 0;
			if($size > 1024) $size = 1024;
		}
	
		// Retrive view variable
		if(array_key_exists('view', $_REQUEST)){
			$view = $_REQUEST['view'];
		}
	
		// Retrive background colour
		$bg = "FFFFFF";
		if(array_key_exists('bg', $_REQUEST)){
			if($_REQUEST['bg'] == "t") $bg = null;
			else{
				$bg_ = parse_col($_REQUEST['bg']);
				if($bg_) $bg = $bg_;
			}
		}
		// Retrive cube colour
		$cc = $view == 'trans' ? $SILVER : $BLACK;
		if(array_key_exists('cc', $_REQUEST)){
			$cc_ = parse_col($_REQUEST['cc']);
			if($cc_) $cc = $cc_;
		}
		// Retrive cube opacity
		$co = $view == 'trans' ? 50 : 100;
		if(array_key_exists('co', $_REQUEST)
		&& preg_match('/^[0-9][0-9]?$/', $_REQUEST['co']))
			$co = $_REQUEST['co'];

		// Retrive face opacity
		$fo = 100;
		if(array_key_exists('fo', $_REQUEST)
		&& preg_match('/^[0-9][0-9]?$/', $_REQUEST['fo']))
			$fo = $_REQUEST['fo'];

			
		// Create default face defs
		for($fc = 0; $fc < 6; $fc++){ for($i = 0; $i < $dim * $dim; $i++)
			$facelets[$fc * $dim * $dim + $i] = $fc;
		}
		// Retrive colour def
		// This overrides face def and makes the $scheme variable redundent (ie, gets reset to default)
		if(array_key_exists('fc', $_REQUEST) && preg_match('/^[ndlswyrobgmpt]+$/', $_REQUEST['fc'])){
			$using_cols = true;
			$scheme = $DEF_SCHEME;
			$uf = $_REQUEST['fc'];
			$nf = strlen($uf);
			for($fc = 0; $fc < 6; $fc++){ for($i = 0; $i < $dim * $dim; $i++){
				// Add user defined face
				if($fc * $dim *$dim + $i < $nf)
					$facelets[$fc * $dim * $dim + $i] = $uf[$fc * $dim *$dim + $i];
				// Otherwise use scheme code
				else
					$facelets[$fc * $dim * $dim + $i] = $schcode[$fc];
			}}
		}
		// Retrive facelet def
		else if(array_key_exists('fd', $_REQUEST) && preg_match('/^[udlrfbnot]+$/', $_REQUEST['fd'])){
			// Map from face names to numeric face ID
			$fd_map = Array('u' => $U, 'r' => $R, 'f' => $F, 'd' => $D, 'l' => $L, 'b' => $B, 'n' => $N, 'o' => $O, 't' => $T);
			$uf = $_REQUEST['fd'];
			$nf = strlen($uf);
			for($fc = 0; $fc < 6; $fc++){ for($i = 0; $i < $dim * $dim; $i++){
				// Add user defined face
				if($fc * $dim *$dim + $i < $nf)
					$facelets[$fc * $dim * $dim + $i] = $fd_map[$uf[$fc * $dim *$dim + $i]];
				// Otherwise default to a blank/transparent face
				else $facelets[$fc * $dim *$dim + $i] = $view == 'trans' ? $T : $N;
			}}
		}
		// Retrive stage variable
		if(array_key_exists('stage', $_REQUEST)){
			$stage = $_REQUEST['stage'];
			// Stage Definitions ]
			if($dim == 3){
				switch($stage){
					case 'fl' :
				$mask = "000000000000000111000000111111111111000000111000000111";
				break;
					case 'f2l' :
				$mask = "000000000000111111000111111111111111000111111000111111";
				break;
					case 'll' :
				$mask = "111111111111000000111000000000000000111000000111000000";
				break;
					case 'cll' :
				$mask = "101000101101000000101000000000000000101000000101000000";
				break;
					case 'ell' :
				$mask = "010111010010000000010000000000000000010000000010000000";
				break;
					case 'oll' :
				$mask = "111111111000000000000000000000000000000000000000000000";
				break;
					case 'coll' :
				$mask = "111111111101000000101000000000000000101000000101000000";
				break;
					case 'ocell' :
				$mask = "111111111010000000010000000000000000010000000010000000";
				break;
				}
			}else if($dim == 2){
				switch($stage){
					case 'fl' :
				$mask = "000000110011111100110011";
				break;
					case 'll' :
				$mask = "111111001100000011001100";
				break;
				}
			}
			// Apply mask to face def
			if($mask){
				for($i = 0; $i < $dim * $dim * 6; $i++){
					$facelets[$i] = $mask[$i] == 0 ?
						($view == 'trans' ? ($using_cols ? 't' : $T) :
						($using_cols ? 'l' : $N)) : $facelets[$i];
				}
			}
		}
			
		// Retrive alg def
		if($dim <= 3 && (array_key_exists('alg', $_REQUEST) || array_key_exists('case', $_REQUEST))){
			require "cube_lib.php";
			$is_alg = array_key_exists('alg', $_REQUEST);
			$alg = $is_alg ? $_REQUEST['alg'] : $_REQUEST['case'];
			$alg = preg_replace('/%27/', "'", $alg);		
			$alg = preg_replace('/[^UDLRFBudlrfbMESxyz\'23]/', '', $alg);
			$alg = preg_replace('/3/', "'", $alg); // Replace 3 with a '
			$alg = preg_replace('/2\'/', "2", $alg); // Replace 2' with a 2
			if($is_alg) $alg = invert_alg($alg);
			$facelets = facelet_cube(case_cube($alg), $dim, $facelets);
		}
		
	
	
		// ---------------[ 3D Cube Generator properties ]---------------
	
		// Projection distance (how close the eye is to the cube)
		$PDIST = 5;

		// Outline width
		$OUTLINE_WIDTH = 0.94;

		// Stroke width
		$sw = 0;

		// Viewport
		$ox = -0.9;
		$oy = -0.9;
		$vw = 1.8;
		$vh = 1.8;
	
		// ------------------[ 3D Cube Generator ]-----------------------

		// Set up cube for OLL view if specified
		if($view == 'plan'){
			$rtn = Array(Array(0, -90));
		}
	
		// All cube face points
		$p = Array();
		// Translation vector to centre the cube
		$t = Array(-$dim/2, -$dim/2, -$dim/2);
		// Translation vector to move the cube away from viewer
		$zpos = Array(0, 0, $PDIST);
		// Rotation vectors to track visibility of each face
		$rv = Array(Array(0, -1, 0), Array(1, 0, 0), Array(0, 0, -1), Array(0, 1, 0), Array(-1, 0, 0), Array(0, 0, 1));
		for($fc = 0; $fc < 6; $fc++){
			for($i = 0; $i <= $dim; $i++){
				for($j = 0; $j <= $dim; $j++){
					switch($fc){
						case $U : $p[$fc][$i][$j] = Array(       $i,    0, $dim - $j); break;
						case $R : $p[$fc][$i][$j] = Array(     $dim,   $j,        $i); break;
						case $F : $p[$fc][$i][$j] = Array(       $i,   $j,         0); break;
						case $D : $p[$fc][$i][$j] = Array(       $i, $dim,        $j); break;
						case $L : $p[$fc][$i][$j] = Array(        0,   $j, $dim - $i); break;
						case $B : $p[$fc][$i][$j] = Array($dim - $i,   $j,      $dim); break;
					}
					// Now scale and tranform point to ensure size/pos independent of dim
					$p[$fc][$i][$j] = translate($p[$fc][$i][$j], $t);
					$p[$fc][$i][$j] = scale($p[$fc][$i][$j], 1 / $dim);
					// Rotate cube as per perameter settings
					foreach($rtn as $rn){
						$p[$fc][$i][$j] = rotate($p[$fc][$i][$j], $rn[0], M_PI * $rn[1]/180);
					}
					// Move cube away from viewer
					$p[$fc][$i][$j] = translate($p[$fc][$i][$j], $zpos);
					// Finally project the 3D points onto 2D
					$p[$fc][$i][$j] = project($p[$fc][$i][$j], $zpos[2]);
				}
			}
			// Rotate rotation vectors
			foreach($rtn as $rn){
				$rv[$fc] = rotate($rv[$fc], $rn[0], M_PI * $rn[1]/180);
			}
		}
	
		// Sort render order (crappy bubble sort)
		$ro = Array(0, 1, 2, 3, 4, 5);
		for($i = 0; $i < 5; $i++){ for($j = 0; $j < 5; $j++){
			if($rv[$ro[$j]][2] < $rv[$ro[$j+1]][2]){
				$t = $ro[$j]; $ro[$j] = $ro[$j+1]; $ro[$j+1] = $t; }
		}}

		// Cube diagram SVG XML
		$cube = "<?xml version='1.0' standalone='no'?>
<!DOCTYPE svg PUBLIC '-//W3C//DTD SVG 1.1//EN' 
'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'>

<svg version='1.1' xmlns='http://www.w3.org/2000/svg'
	width='$size' height='$size'
	viewBox='$ox $oy $vw $vh'>\n";
if($bg) $cube .= "\t<rect fill='#$bg' x='$ox' y='$oy' width='$vw' height='$vh'/>\n";

		// Transparancy background rendering
		if($co < 100){
			// Create polygon for each background facelet (transparency only)
			$cube .= "\t<g opacity='$fo%' stroke-opacity='50%' stroke-width='$sw' stroke-linejoin='round'>\n";
			for($ri = 0; $ri < 3; $ri++){
				$cube .= facelet_svg($ro[$ri]);
			}
			$cube .= "\t</g>\n";
		
			// Create outline for each background face (transparency only)
			$cube .= "\t<g stroke-width='0.1' stroke-linejoin='round' opacity='$co%'>\n";	
			for($ri = 0; $ri < 3; $ri++)
				$cube .= outline_svg($ro[$ri]);
			$cube .= "\t</g>\n";	
		}

		// Create outline for each visible face
		$cube .= "\t<g stroke-width='0.1' stroke-linejoin='round' opacity='$co%'>\n";	
		for($ri = 3; $ri < 6; $ri++){
			if(face_visible($ro[$ri], $rv) || $co < 100)
				$cube .= outline_svg($ro[$ri]);
		}
		$cube .= "\t</g>\n";	

		// Create polygon for each visible facelet
		$cube .= "\t<g opacity='$fo%' stroke-opacity='50%' stroke-width='$sw' stroke-linejoin='round'>\n";
		for($ri = 3; $ri < 6; $ri++){
			if(face_visible($ro[$ri], $rv) || $co < 100)
				$cube .= facelet_svg($ro[$ri]);
		}
		$cube .= "\t</g>\n";
		
		// Create OLL view guides
		if($view == 'plan'){
			$cube .= "\t<g opacity='$fo%' stroke-opacity='100%' stroke-width='0.02' stroke-linejoin='round'>\n";
			$toRender = Array($F, $L, $B, $R);
			foreach($toRender as $fc)
				$cube .= oll_svg($fc);
			$cube .= "\t</g>\n";
		}
	
		$cube .= "</svg>\n";


		


		// Display cube
		if($DEBUG) echo $cube;
		else{
			$img = $fmt != 'svg' ? convert($cube, $fmt) : $cube;
			display_img($img, $fmt);
			
			// Cache image if enabled
			if($ENABLE_CACHE && !array_key_exists("nocache", $_REQUEST) && strlen($img) < $CACHE_IMG_SIZE_LIMIT){
				$req = mysql_real_escape_string($_SERVER['QUERY_STRING']);
				$rfr = mysql_real_escape_string($_SERVER['HTTP_REFERER']);
				$hash = md5($req);
				$img = mysql_real_escape_string($img);
				mysql_query("INSERT INTO vcache(hash, fmt, req, rfr, rcount, img) ".
						"VALUES ('$hash', '$fmt', '$req', '$rfr', 1, '$img')");
				// Disconnect from db
				mysql_close();
			}
		}
	}





	

	// -----------------[ User input functions ]----------------------
	
	// Parse colour value
	function parse_col($col){
		global $NAME_COL, $ABBR_COL;
		// As an abbriviation
		if(preg_match('/^[ndlswyrogbpmt]$/', $col))
			return $ABBR_COL[$col];
		// As a name
		if(array_key_exists($col, $NAME_COL))
			return $NAME_COL[$col];
		// As 12-bit colour
		if(preg_match('/^[0-9a-fA-F]{3}$/', $col))
			return $col[0].$col[0].$col[1].$col[1].$col[2].$col[2];
		// As 24-bit colour
		if(preg_match('/^[0-9a-fA-F]{6}$/', $col))
			return $col;
		// Otherwise fail
		return null;
	}






	// -------------------[ 3D Geometry Functions ]--------------------
	
	// Move point by translation vector
	function translate($p, $t){
		$p[0] += $t[0];
		$p[1] += $t[1];
		$p[2] += $t[2];
		return $p;
	}

	function scale($p, $f){
		$p[0] *= $f;
		$p[1] *= $f;
		$p[2] *= $f;
		return $p;
	}
	
	// Scale point relative to position vector
	function trans_scale($p, $v, $f){
		// Translate each facelet to cf
		$iv = Array(-$v[0], -$v[1], -$v[2]);
		return translate(scale(translate($p, $iv), $f), $v);		
	}

	function rotate($p, $ax, $an){
		$np = Array($p[0], $p[1], $p[2]);	
		switch($ax){
			case 0 :
				$np[2] = $p[2] * cos($an) - $p[1] * sin($an);
				$np[1] = $p[2] * sin($an) + $p[1] * cos($an);
				break;
			case 1 :
				$np[0] =   $p[0] * cos($an) + $p[2] * sin($an);
				$np[2] = - $p[0] * sin($an) + $p[2] * cos($an);
				break;
			case 2 :
				$np[0] = $p[0] * cos($an) - $p[1] * sin($an);
				$np[1] = $p[0] * sin($an) + $p[1] * cos($an);
				break;
		}
		return $np;
	}

	// Project 3D points onto a 2D plane
	function project($p, $d){
		return Array(
			$p[0] * $d / $p[2],
			$p[1] * $d / $p[2],
			$p[2] // Maintain z coordinate to allow use of rendering tricks
		);
	}

	// Returns whether a face is visible
	function face_visible($face, $rv){
		return $rv[$face][2] < -0.105;
	}




	// ---------------------------[ Rendering Functions ]----------------------------
	
	// Returns svg for a cube outline
	function outline_svg($fc){
		global $p, $dim, $cc, $OUTLINE_WIDTH; 
		return "\t\t<polygon fill='#$cc' stroke='#$cc' points='".
			$p[$fc][   0][   0][0]*$OUTLINE_WIDTH.','.$p[$fc][   0][   0][1]*$OUTLINE_WIDTH.' '.
			$p[$fc][$dim][   0][0]*$OUTLINE_WIDTH.','.$p[$fc][$dim][   0][1]*$OUTLINE_WIDTH.' '.
			$p[$fc][$dim][$dim][0]*$OUTLINE_WIDTH.','.$p[$fc][$dim][$dim][1]*$OUTLINE_WIDTH.' '.
			$p[$fc][   0][$dim][0]*$OUTLINE_WIDTH.','.$p[$fc][   0][$dim][1]*$OUTLINE_WIDTH."'/>\n";
	}

	// Returns svg for a faces facelets
	function facelet_svg($fc){
		global $p, $dim;
		for($i = 0; $i < $dim; $i++){
			for($j = 0; $j < $dim; $j++){
				// Find centre point of facelet
				$cf = Array(($p[$fc][$j  ][$i  ][0] + $p[$fc][$j+1][$i+1][0])/2,
					($p[$fc][$j  ][$i  ][1] + $p[$fc][$j+1][$i+1][1])/2, 0);
				// Scale points in towards centre
				$p1 = trans_scale($p[$fc][$j  ][$i  ], $cf, 0.85);
				$p2 = trans_scale($p[$fc][$j+1][$i  ], $cf, 0.85);
				$p3 = trans_scale($p[$fc][$j+1][$i+1], $cf, 0.85);
				$p4 = trans_scale($p[$fc][$j  ][$i+1], $cf, 0.85);
				// Generate facelet polygon
				$svg .= gen_facelet($p1, $p2, $p3, $p4, $fc * $dim * $dim + $i * $dim + $j);
			}
		}
		return $svg;	
	}
	
	// Renders the top rim of the R U L and B faces out from side of cube
	function oll_svg($fc){
		global $p, $dim, $rv;
		// Translation vector, to move faces out
		$tv1 = scale($rv[$fc], 0.00);
		$tv2 = scale($rv[$fc], 0.20);
		$i = 0;
		for($j = 0; $j < $dim; $j++){
				// Find centre point of facelet
				$cf = Array(($p[$fc][$j  ][$i  ][0] + $p[$fc][$j+1][$i+1][0])/2,
					($p[$fc][$j  ][$i  ][1] + $p[$fc][$j+1][$i+1][1])/2, 0);
				// Scale points in towards centre and skew
				$p1 = translate(trans_scale($p[$fc][$j  ][$i  ], $cf, 0.94), $tv1);
				$p2 = translate(trans_scale($p[$fc][$j+1][$i  ], $cf, 0.94), $tv1);
				$p3 = translate(trans_scale($p[$fc][$j+1][$i+1], $cf, 0.94), $tv2);
				$p4 = translate(trans_scale($p[$fc][$j  ][$i+1], $cf, 0.94), $tv2);
				// Generate facelet polygon
				$svg .= gen_facelet($p1, $p2, $p3, $p4, $fc * $dim * $dim + $i * $dim + $j);
				
		}
		return $svg;
	}
	
	/** Generates a polygon SVG tag for cube facelets */
	function gen_facelet($p1, $p2, $p3, $p4, $seq){
		global $ABBR_COL, $facelets, $scheme, $using_cols, $cc, $T;
		$fcol = $using_cols ? ($facelets[$seq] == 't' ? 't' : $ABBR_COL[$facelets[$seq]])
		                    : ($facelets[$seq] == $T ? 't' : $scheme[$facelets[$seq]]);
		return "\t\t<polygon fill='#".
			($fcol == 't' ? '000000' : $fcol)."' stroke='#$cc' ".
			($fcol == 't' ? "opacity='0' " : ' ' )."points='".
				$p1[0].','.$p1[1].' '.
				$p2[0].','.$p2[1].' '.
				$p3[0].','.$p3[1].' '.
				$p4[0].','.$p4[1]."'/>\n";
	}
	
	/** Converts svg into given format */
	function convert($svg, $fmt) {
		$opts = gen_image_opts($fmt);
		$descriptorspec = array(0 => array("pipe", "r"), 1 => array("pipe", "w"));
		$convert = proc_open("/usr/bin/convert $opts svg:- $fmt:-", $descriptorspec, $pipes);
		fwrite($pipes[0], $svg);
		fclose($pipes[0]);
		while(!feof($pipes[1])) {
			$img .= fread($pipes[1], 1024);
		}
		fclose($pipes[1]);
		proc_close($convert);
		return $img;
	}
	
	/** Alternative version using files rather than pipes,
	not desired because of collission possibilities.. */
	function convert_file($svg, $fmt) {
		$svgfile = fopen("/tmp/visualcube.svg", 'w');
		fwrite($svgfile, $svg);
		fclose($svgfile);
		$opts = gen_image_opts($fmt);
		$rsvg = exec("/usr/bin/convert $opts /tmp/visualcube.svg /tmp/visualcube.$fmt");
		$imgfile = fopen("/tmp/visualcube.$fmt", 'r');
		while($imgfile and !feof($imgfile)) {
			$img .= fread($imgfile, 1024);
		}
		fclose($imgfile);
		return $img;
	}
	
	/** Generate ImageMagic optoins depenting on format */
	function gen_image_opts($fmt){
//		$opts .= '+label "Generated by VisualCube"';
//		$opts .= ' -comment "Generated by VisualCube"';
//		$opts .= ' -caption "Generated by VisualCube"';
//		$opts = "-gaussian 1";
		switch($fmt){
			case 'png' : $opts .= " -background none -quality 100";
			break;
			case 'gif' : $opts .= " -background none";
			break;
			case 'ico' : $opts .= " -background none";
			break;
			case 'jpg' : $opts .= " -quality 90";
			break;
			
		}
		return $opts;
	}
	
	/** Sends image to browser */
	function display_img($img, $fmt){
		$mime = $fmt;
		switch($fmt){
			case 'jpg' : $mime = 'jpeg'; break;
			case 'svg' : $mime = 'svg+xml'; break;
			case 'ico' : $mime = 'vnd.microsoft.icon'; break;
		}
		header("Content-type: image/$mime");
//		header("Content-Length: " . filesize($img) ."; "); 
		echo $img;
	}
	
	
	
	
	
	// -----------------------------[ DB Access Functions ]--------------------------
	
	// Return result of sql query as array
	function get_arrays($query){
		$result = mysql_query($query);
		$count = mysql_numrows($result);
		if($count <= 0) return null;
		$ary = Array($count);
		$i = 0;
		while($record = mysql_fetch_array($result, MYSQL_ASSOC)){
			$ary[$i] = $record;
			$i++;
		}
		return $ary;
	}
?>
