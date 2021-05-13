<?php



$slug = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/default' ;
 
$f	= fopen( 'redirects.txt', 'r' );
$urls	= array();
 
// The file didn't open correctly.
if ( !$f ) {
	echo 'Make sure you create your redirects.txt file and that it\'s readable by the redirect script.';
	die;
}
 
// Read the input file and parse it into an array
while( $data = fgetcsv( $f ) ) {
	if ( !isset( $data[0] ) || !isset( $data[1] ) )
		continue;
	
	$key = trim( $data[0] );
	$val = trim( $data[1] );
	$urls[ $key ] = $val;
}
 
// Check if the given ID is set, if it is, set the URL to that, if not, default
$url = ( isset( $urls[ $slug ] ) ) ? $urls[ $slug ] : ( isset( $urls[ '/default' ] ) ? $urls[ '/default' ] : false );

if ( $url ) {
	header( "X-Robots-Tag: noindex, nofollow", true );
	
?>

<!DOCTYPE html>
		<html>
		<head>

		

		<style>
		*{
			margin:0px;
			border:0px;
			padding:0px;
		}
		body {
			overflow: hidden;
			//overflow: visible;
		}
		html, body, iframe { height: 100%; }
		</style>
		
		
		</head>
		<body>
			
			
			<div style="display:none;"></div>
			
			<iframe src="<?=$url?>" height="100%" width="100%" noresize="noresize"></iframe>
			
		

		
		
		<input type="hidden" id="back_redir_hidden" value="">
		

		</body>
		</html>
		


<?php
	
	

	
	die;	
} else {
	echo '<p>Make sure yor redirects.txt file contains a default value, syntax:</p>
	<pre>default,http://example.com</pre>
	<p>Where you should replace example.com with your domain.</p>';
}