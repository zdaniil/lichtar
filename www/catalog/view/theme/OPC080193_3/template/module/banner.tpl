<?php 
		$sliderForbanner = 1;
		$bannercount = sizeof($banners); 	
?>	
<div id="banner<?php echo $module; ?>" class="<?php if ($bannercount > $sliderForbanner){?> owl-carousel bannercarousel <?php }else{?>single-banner<?php }?>">
  <?php foreach ($banners as $banner) { ?>
  <div class="item">
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>
  </div>
  <?php } ?>
</div>
<script type="text/javascript"><!--
$('.bannercarousel').owlCarousel({
	items: 1,
	autoPlay: 3000,
	singleItem: true,
	navigation: false,
	pagination: true,
	transitionStyle: 'fade'
});
--></script>