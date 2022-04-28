<?php
  /*
    Template Name: App Template
  */

get_header();
$bg_url = get_field('client_background_image')['url'];
$intro_text = get_field('client_introduction');
$current_rsp_offers_posts = get_field('offers');
$current_rsp_offers = array();
foreach($current_rsp_offers_posts as $this_post){
	$current_rsp_offers[] = $this_post->ID;
}
$this_url = get_the_permalink();
$sw_name = (str_replace(' ', '-', strtolower(get_the_title())).'-sw.js'); //for the service worker
$sw_scope = str_replace(' ', '-', strtolower(get_the_title()));//the scope
$affiliate_code = str_replace(' ', '',get_field('affliate_code'));
add_filter('the_category','search_display_categories');
function search_display_categories($thelist)
{
	global $this_url;
	$return_arr = array();
	$thelist_array = explode(',',$thelist);
	foreach($thelist_array as $this_cat_link){

		if(substr($this_cat_link,0,2) == '<a' && !preg_match('/\buncategorized\b/',$this_cat_link)){
			preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $this_cat_link, $result);

			if(!empty($result)){
				$return_arr[] = ucwords(str_replace('/',' >> ',str_replace('-',' ',rtrim(substr($result['href'][0],36),'/'))),'> ');
			}

		}
	}
	return $return_arr;
}
?>
<style>
.grid{
    width: 90%;
    height: auto;
    margin: 0 auto;
    position: relative;
}
.grid-item {
 	height:250px;
	border: 0.5px black solid;
	width:250px;
}
.grid-item h2{
	text-align:center;
	margin:5px;

}
.grid-item img {
  display: block;
  max-width: 100%;
  padding:5px;
}
.grid-item-img{
	height:150px;
	width:150px;
	display : flex;
    align-items : center;
    margin: auto;
}
.grid-item-links{
    position: absolute;
    bottom: 10px;
    width:100%;
    padding:5px 15px;
}
.grid-item-excerpt{
	padding:5px 10px;
	height:30px;
	overflow:hidden;
}
.grid-item-links a{
	padding-right:5px;
}
#chrome-install-prompt{
	position:fixed;
	top:0px;
	display:none;
	width:100%;
	opacity:0.8;
	z-index:9999;
}
.wcp-carousel-main-wrap{
	max-width:100%;
}



@media only screen and (min-width: 1200px){
	.container{
		width:950px;
	}

}
@media only screen and (max-width:768px) and (orientation : portrait) {
	.grid-item{
		width:90%!important;
	}
}
</style>



<?php
if ( have_posts() ) : ?>
	<?php while ( have_posts() ) { the_post(); ?>
		<div class="page-single">
			<main class="page-single__content" role="main">
			<?php


$query = new WP_Query(array(
    'post_type' => 'offer',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'			 => 'ASC'
));
$query_parent_cats= array(
	'post_type' => 'offer',
    'post_status' => 'publish',
    'parent'  => 0
);
$query_parent_cats= array(
	'post_type' => 'offer',
    'post_status' => 'publish',
    'parent'  => 0
);

$cat_search_array = array();

foreach ($current_rsp_offers as $offer_id){


$this_list_arr = get_the_category_list(',','single',$offer_id);

	foreach ($this_list_arr as $cat_string){
		if(!in_array($cat_string,$cat_search_array))
			$cat_search_array[] = $cat_string;
	}
}

$search_data_string = implode("','", $cat_search_array);
$search_data_string = "'".$search_data_string."'";
//var_dump($cats);



?>

<div class="row" style="background-color:#fff;padding:15px">
	<div class="col-md-12">
	<?php echo '<h1 style="text-align:center">'.get_the_title().'</h1>' ?>
    </div>
	<div class="col-md-12">
		<?php echo $intro_text ?>
	</div>
	<div class="col-md-12">
		<p></p>
		<p>Start typing below to see a list of available offers.</p>
	</div>


			<h2 style="width:100%">
				<form name="searchform" id="seachform">
					<div class="col-md-12">
						<input type="text" id="search" placeholder="Find me offers on..." name="itemsearch" />
					</div>
				</form>
			</h2>
		<div class="col-md-12">
			<p>Suggested Searches (click to search):</p><p><button class="btn btn-outline-primary quicksearch">Travel</button><button class="btn btn-outline-primary quicksearch">Travel >> Accommodation</button><button class="btn btn-outline-primary quicksearch">Fashion</button><button class="btn btn-outline-primary quicksearch">Fashion >> Womens</button></p>
		</div>
	</div>
<p></p>
</div>
<div class="row" style="background-color:#fff;margin:10px 0px">

</div>
<div class="row" style="background-color:#fff;padding:15px">

	<div class="grid">
<?php

while ($query->have_posts()) {
	$query->the_post();

	if(in_array(get_the_ID(),$current_rsp_offers)){

	    $url =  get_post_meta(get_the_ID(), 'code_',true);
	    $affiliate_manager = get_post_meta(get_the_ID(), 'affiliate_manager',true);
	    $link_suffix = "";
	    switch($affiliate_manager){
	    	case 'Commission Factory':
	    	$link_suffix = "&UniqueId=".$affiliate_code;
	    	break;
	    	case 'Rakuten':
	    	$link_suffix = "&u1=".$affiliate_code;
	    	break;
	    	case 'Commission Junction':
	    	$link_suffix = "?sid=".$affiliate_code;
	    	break;
	    	case 'Hotels Combined':
	    	$link_suffix = "&label=".$affiliate_code;
	    	break;
	    }

	    $featured = get_post_meta(get_the_ID(), 'featured_offer',true);
	    $grid_text = get_post_meta(get_the_id(),'grid_text',true);
		$categories = get_the_category(get_the_ID());
		$filterstring = "";
		foreach ($categories as $category){
			$filterstring .= $category->slug." ";
		}
		if($featured){
			$filterstring .= "featured ";
		}
		echo '<div class="grid-item ' . $filterstring . 'filter-all">';
		echo '<a href="'.$url.$link_suffix.'"><div class="grid-item-img" >'.get_the_post_thumbnail(null,'thumb').'</div></a>';
		echo '<div class="grid-item-excerpt">'.$grid_text.'</div>';
		echo '<div class="grid-item-links"><a href="'.$url.$link_suffix.'"><button type="button" class="btn btn-success" style="float:left">Get Offer</button></a><a href="'. get_the_permalink().'"><button type="button" class="btn btn-info" style="float:right">Read More</button></a></div>';
		echo '</div>';
	}

}?>
			</div>
		</div>
			</main>
		</div>
	<?php } ?>

<?php else : ?>
	<?php get_template_part( 'content', 'none' ); ?>
<?php endif;
?>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/isotope-cells-by-row@1.1.4/cells-by-row.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

  if ('serviceWorker' in navigator) {
    navigator.serviceWorker
             .register('<?php echo get_site_url(); ?>/<?php echo $sw_name?>')
             .then(function() { console.log('Service Worker Registered'); });
  }
String.prototype.replaceAll = function(str1, str2, ignore)
{
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
}
var theme_assets_images = "<?php echo get_template_directory_uri().'/assets/images'; ?>";



var isIphone = navigator.userAgent.indexOf("iPhone") != -1 ;
var isIpod = navigator.userAgent.indexOf("iPod") != -1 ;
var isIpad = navigator.userAgent.indexOf("iPad") != -1 ;
var isIos = isIphone ;
console.log('iPod:' + isIpod);
console.log('iPad:' + isIpad);
console.log('iPhone:' + isIphone);
isInWebAppiOS = (window.navigator.standalone == true);
//var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
var isChrome = (navigator.userAgent.match('CriOS'));

let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
  // Prevent Chrome 67 and earlier from automatically showing the prompt
  e.preventDefault();
  // Stash the event so it can be triggered later.
  deferredPrompt = e;
  console.log('install prompt ready');
  jQuery('#chrome-install-prompt').toggle('slide');
});

//set up the search filter array
var data = [
<?php echo $search_data_string ?>
];


var $grid = jQuery('.grid').isotope({
  itemSelector: '.grid-item',
  masonry: {
    columnWidth: 250,
    isFitWidth: true
  }
});

	jQuery ('#btnAdd').click(function(e){
		e.preventDefault();
		jQuery('#chrome-install-prompt').hide();
		  // Show the prompt
		  deferredPrompt.prompt();
		  // Wait for the user to respond to the prompt
		  deferredPrompt.userChoice
		    .then((choiceResult) => {
		      if (choiceResult.outcome === 'accepted') {
		        console.log('User accepted the A2HS prompt');
		      } else {
		        console.log('User dismissed the A2HS prompt');
		      }
		      deferredPrompt = null;
			});
	})

   jQuery( "#search" ).autocomplete({

      delay: 0,
      source: data,
      open: function(event, ui) {
      	jQuery('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
      },
      focus: function(event, ui) {
	    jQuery(this).val(ui.item.value);
	    jQuery(".ui-menu").hide();
	  },
      change: function (event, ui) {
            if(!ui.item){
                //http://api.jqueryui.com/autocomplete/#event-change -
                // The item selected from the menu, if any. Otherwise the property is null
                //so clear the item for force selection
                $("#search").val("");
                }
               jQuery(this).blur();

        },
      select: function(event,ui){
      	filterValue = "." + ui.item.value.toLowerCase().replaceAll(" >> ",".").replaceAll(" ","-").trim();
      	console.log(filterValue);


      	$grid.isotope({ filter: filterValue });

      }
    });""

        $grid.imagesLoaded().progress( function() {
          $grid.isotope('layout');
        });


jQuery(function(){


	iPhoneInstallOverlay.init({
	  blurElement: '.page-single',
	  spritesURL: theme_assets_images + '/mobile-sprite.png',
	  appName: 'WhatsOn Reverse Sponsorship'
	});


  if(isIos && !isInWebAppiOS && !isChrome){
  		iPhoneInstallOverlay.showOverlay();

  }

  if (isIos && !isInWebAppIos && isChrome){
	jQuery('#chrome-install-prompt').hide()
  }

  var PageLoadFilter = '.featured';
  $grid.isotope({ filter: PageLoadFilter});
  jQuery('#seachform').submit(function(e){
  	e.preventDefault();
  	filterValue = "." + jQuery('#search').val().toLowerCase().replaceAll(" >> ",".").replaceAll(" ","-").trim();
    $grid.isotope({ filter: filterValue });
    console.log('search form submit');
    console.log(filterValue);


  })

})

/*jQuery(function(){

	jQuery('body').css("background-image","url('<?php echo $bg_url ?>')");
	jQuery('body').css("background-position", "center");
	jQuery('body').css("background-size","cover");
})
jQuery(window).resize(function(){
	jQuery('body').css("background-image","url('<?php echo $bg_url ?>')");
	jQuery('body').css("background-position", "center");
	jQuery('body').css("background-size","cover");
})*/
jQuery('.quicksearch').on('click',function(){
	jQuery('#search').val(jQuery(this).text());
	jQuery('#search').autocomplete('search');
	console.log(jQuery(this).text());
})
</script>
<?php

get_footer(); ?>
