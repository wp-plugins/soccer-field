<?php
/*
Plugin Name: Soccer Field
Plugin URI: http://www.danycode.com/soccer-field/
Description: When called this plugin shows a Soccer Field inside your post.
Version: 1.04
Author: Danilo Andreini
Author URI: http://www.danycode.com
License: GPLv2 or later
*/

/*  Copyright 2012  Danilo Andreini (email : andreini.danilo@gmail.com)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

//options initialization
if(strlen(get_option('soccer_field_bg_color'))==0){update_option('soccer_field_bg_color',"00CF86");}
if(strlen(get_option('soccer_field_team1_color'))==0){update_option('soccer_field_team1_color',"FFFFFF");}
if(strlen(get_option('soccer_field_team2_color'))==0){update_option('soccer_field_team2_color',"FFFFFF");}

//hooks
add_action( 'wp_head', 'soccer_field_add_css' );
add_action( 'admin_head', 'soccer_field_add_css' );
add_action( 'admin_menu', 'soccer_field_menu' );
add_shortcode( 'soccer', 'display_field');

//functions
function soccer_field_add_css()
{
echo '<link rel="stylesheet" type="text/css" media="all" href="'.WP_PLUGIN_URL.'/soccer-field/css/style.css" />';
}

function soccer_field_menu() {
	add_options_page( 'Soccer Field', 'Soccer Field', 'manage_options', 'soccer_field_options', 'soccer_field_options' );
}

function soccer_field_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}   
    // Save options if user has posted some information
    if(isset($_POST[color1]) or isset($_POST[color2]) or isset($_POST[color3])){        
        $color1=$_POST[color1];$color2=$_POST[color2];$color3=$_POST[color3];
        //check if is an hexadecimal RGB color
        $error=0;
	    if(!preg_match('/^([0-9a-f]{1,2}){3}$/i',$color1)){$error=1;}
	    if(!preg_match('/^([0-9a-f]{1,2}){3}$/i',$color2)){$error=1;}
	    if(!preg_match('/^([0-9a-f]{1,2}){3}$/i',$color3)){$error=1;}
        if($error==0){
			// Save into database
			update_option('soccer_field_bg_color',$color1);
			update_option('soccer_field_team1_color',$color2);
			update_option('soccer_field_team2_color',$color3);
			echo '<p class="sf-saved">Your options have been saved</p>';
		}else{
			//show error message
			echo '<p class="sf-saved">Only RGB colors are allowed</p>';
		}
	}	
	echo '<h2>Soccer Field Options</h2>';
	echo '<form method="post" action="">';
	echo '<input autocomplete="off" maxlength="6" size="6" type="text" name="color1" value="'.get_option('soccer_field_bg_color').'"><span>Field color</span><br />';
	echo '<input autocomplete="off" maxlength="6" size="6" type="text" name="color2" value="'.get_option('soccer_field_team1_color').'"><span>Team 1 color</span><br />';
	echo '<input autocomplete="off" maxlength="6" size="6" type="text" name="color3" value="'.get_option('soccer_field_team2_color').'"><span>Team 2 color</span><br />';
	echo '<input type="submit" value="Save">';
	echo '</form>';
	echo '<h2>How to use Soccer Field</h2>';
	echo 'Embed a soccer field in the content of the posts using the following code: (This example refer to ITALY vs FRANCE world cup 2006)';
	echo "<code class='sf-code'>[soccer p1a='Gianluigi Buffon' p2a='Gianluca Zambrotta' p3a='Fabio Cannavaro' p4a='Marco Materazzi' p5a='Fabio Grosso' p6a='Gennaro Gattuso' p7a='Andrea Pirlo' p8a='Mauro Camoranesi' p9a='Simone Perrotta' p10a='Francesco Totti' p11a='Luca Toni' p1b='Fabien Barthez' p2b='Willy Sagnol' p3b='Lilian Thuram' p4b='William Gallas' p5b='Eric Abidal' p6b='Patrick Vieira' p7b='Claude Makelele' p8b='Franck Ribery' p9b='inedine Zidane' p10b='Florent Malouda' p11b='Thierry Henry']</code>";
	echo '<p>Ask for support at <a target="_blank" href="http://www.danycode.com/soccer-field/">Soccer Field Official Page</a></p>';	
}
function display_field( $atts ) {
	extract( shortcode_atts( array(
		'p1a' => 'player1',
		'p2a' => 'player2',
		'p3a' => 'player3',
		'p4a' => 'player4',
		'p5a' => 'player5',
		'p6a' => 'player6',
		'p7a' => 'player7',
		'p8a' => 'player8',
		'p9a' => 'player9',
		'p10a' => 'player10',
		'p11a' => 'player11',
		'p1b' => 'player1',
		'p2b' => 'player2',
		'p3b' => 'player3',
		'p4b' => 'player4',
		'p5b' => 'player5',
		'p6b' => 'player6',
		'p7b' => 'player7',
		'p8b' => 'player8',
		'p9b' => 'player9',
		'p10b' => 'player10',
		'p11b' => 'player11'
	), $atts ) );	
	$res='<div class="soccer-field" style="background-color: #'.get_option("soccer_field_bg_color").'">';	
	
	$res.='<div class="sf-team1 sf-p1a" style="color: #'.get_option("soccer_field_team1_color").'">'.$p1a.'</div>';
	$res.='<div class="sf-team1 sf-p2a" style="color: #'.get_option("soccer_field_team1_color").'">'.$p2a.'</div>';
	$res.='<div class="sf-team1 sf-p3a" style="color: #'.get_option("soccer_field_team1_color").'">'.$p3a.'</div>';
	$res.='<div class="sf-team1 sf-p4a" style="color: #'.get_option("soccer_field_team1_color").'">'.$p4a.'</div>';
	$res.='<div class="sf-team1 sf-p5a" style="color: #'.get_option("soccer_field_team1_color").'">'.$p5a.'</div>';
	$res.='<div class="sf-team1 sf-p6a" style="color: #'.get_option("soccer_field_team1_color").'">'.$p6a.'</div>';
	$res.='<div class="sf-team1 sf-p7a" style="color: #'.get_option("soccer_field_team1_color").'">'.$p7a.'</div>';
	$res.='<div class="sf-team1 sf-p8a" style="color: #'.get_option("soccer_field_team1_color").'">'.$p8a.'</div>';
	$res.='<div class="sf-team1 sf-p9a" style="color: #'.get_option("soccer_field_team1_color").'">'.$p9a.'</div>';
	$res.='<div class="sf-team1 sf-p10a" style="color: #'.get_option("soccer_field_team1_color").'">'.$p10a.'</div>';
	$res.='<div class="sf-team1 sf-p11a" style="color: #'.get_option("soccer_field_team1_color").'">'.$p11a.'</div>';
		
	$res.='<div class="sf-team2 sf-p1b" style="color: #'.get_option("soccer_field_team2_color").'">'.$p1b.'</div>';
	$res.='<div class="sf-team2 sf-p2b" style="color: #'.get_option("soccer_field_team2_color").'">'.$p2b.'</div>';
	$res.='<div class="sf-team2 sf-p3b" style="color: #'.get_option("soccer_field_team2_color").'">'.$p3b.'</div>';
	$res.='<div class="sf-team2 sf-p4b" style="color: #'.get_option("soccer_field_team2_color").'">'.$p4b.'</div>';
	$res.='<div class="sf-team2 sf-p5b" style="color: #'.get_option("soccer_field_team2_color").'">'.$p5b.'</div>';
	$res.='<div class="sf-team2 sf-p6b" style="color: #'.get_option("soccer_field_team2_color").'">'.$p6b.'</div>';
	$res.='<div class="sf-team2 sf-p7b" style="color: #'.get_option("soccer_field_team2_color").'">'.$p7b.'</div>';
	$res.='<div class="sf-team2 sf-p8b" style="color: #'.get_option("soccer_field_team2_color").'">'.$p8b.'</div>';
	$res.='<div class="sf-team2 sf-p9b" style="color: #'.get_option("soccer_field_team2_color").'">'.$p9b.'</div>';
	$res.='<div class="sf-team2 sf-p10b" style="color: #'.get_option("soccer_field_team2_color").'">'.$p10b.'</div>';
	$res.='<div class="sf-team2 sf-p11b" style="color: #'.get_option("soccer_field_team2_color").'">'.$p11b.'</div>';	
	$res.='</div>';	
	return $res;
}

?>
