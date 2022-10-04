<?php  
/** 
 Template Name: All Blogs Bitly
Description: A page template that provides a key component of WordPress as a CMS  * by meeting the need for a carefully crafted introductory page. The front page template  * in Twenty Twelve consists of a page content area for adding text, images, video --  * anything you'd like -- followed by front-page-only widgets in one or two columns.  *  * @package WordPress  * @subpackage Twenty_Twelve  * @since Twenty Twelve 1.0  */ 
  get_header(); 
  ?> 
  
    <div id="section">  
	<h1>
	<?php the_title(); ?>	
	</h1>	
 <table>
	<?php
	$args = array(  
		'posts_per_page'   => '100',
		'offset'           => '', 
		'orderby'          => 'post_date',
		'order'  => 'DESC', 
		'include'          => '',
		'exclude'          => '', 
		'meta_key'         => '', 
		'meta_value'       => '', 
		'post_type'        => 'post',
		'post_mime_type'   => '', 
		'post_parent'      => '', 
		'post_status'      => 'publish', 
	'suppress_filters' => true );   ?>  
	<?php $postslist = get_posts( $args );
	foreach ( $postslist as $post ) :  setup_postdata( $post ); ?>   
    <tr>
	<td> <?php echo get_the_title(); ?></td><td><?php the_permalink(); ?></td><td><?php  echo bitlyShortUrl(get_permalink());?></td>
	</tr>	
         <?php  endforeach;  
		  wp_reset_postdata();  ?>  
</table>
 
 
 
 <?php

function bitlyShortUrl($long_url)
{
	//$long_url = 'https://stackoverflow.com/questions/ask';
	$apiv4 = 'https://api-ssl.bitly.com/v4/bitlinks';
	$genericAccessToken = '92cbcb7d7bf7ce08add07360776c2567c00d9c41';
	$data = array(
		'long_url' => $long_url
	);
	$payload = json_encode($data);
	$header = array(
		'Authorization: Bearer ' . $genericAccessToken,
		'Content-Type: application/json',
		'Content-Length: ' . strlen($payload)
	);
	
	$ch = curl_init($apiv4);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	$result = curl_exec($ch);
	$resultToJson = json_decode($result);
	echo $resultToJson->link;
}   
   
    