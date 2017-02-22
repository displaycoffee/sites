<?php
	/**
	* Template for displaying social sharing buttons
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<div class="sharing-buttons menu-social-container">
    <?php _e( '<strong>Share On:</strong>', 'musescircle' ); ?>
    <ul class="menu">
		<li>			    
		    <a href="//www.facebook.com/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank">Facebook</a>	    
		</li>
		<li>			   
		    <a href="//plus.google.com/share?url=<?php echo get_permalink(); ?>" target="_blank">Google+</a>	    
		</li>
		<li>			  
		    <a href="//www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_permalink(); ?>" target="_blank">LinkedIn</a>	
		</li>
		<li>
		    <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">Pinterest</a>
		</li>
		<li>
		    <a href="//www.tumblr.com/share/link?url=<?php echo get_permalink(); ?>&amp;title=<?php echo get_the_title(); ?>" target="_blank">Tumblr</a>
		</li>
		<li>			   
		    <a href="//twitter.com/share?url=<?php echo get_permalink(); ?>&amp;text=<?php echo get_the_title(); ?>&amp;hashtags=themusescircle" target="_blank">Twitter</a>
		</li>			
		<li>
		    <a href="//reddit.com/submit?url=<?php echo get_permalink(); ?>&amp;title=<?php echo get_the_title(); ?>" target="_blank">Reddit</a>
		</li>
    	<li>
		    <a href="//www.digg.com/submit?url=<?php echo get_permalink(); ?>" target="_blank">Digg</a>
		</li>
		<li>
		    <a href="//www.stumbleupon.com/submit?url=<?php echo get_permalink(); ?>&amp;title=<?php echo get_the_title(); ?>" target="_blank">StumbleUpon</a>
		</li>
		<li>
		    <a href="mailto:?Subject=<?php echo get_the_title(); ?>&amp;Body=Shared%20from%20themusescircle.com%20 <?php echo get_permalink(); ?>">Email</a>	 
		</li>			
    </ul>
</div>