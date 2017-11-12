<div class="main-slider">
<div id="spinner"></div>
<div id="slideshow<?php echo $module; ?>" class="owl-carousel" style="opacity: 1;">
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
</div>
<script type="text/javascript">
$(document).ready(function(){	
	$('#slideshow<?php echo $module; ?>').owlCarousel({
	items: 6,
	autoPlay: 3000,
	singleItem: true,
	navigation: true,
	navigationText: ['<i class="fa fa-long-arrow-left fa-5x"></i>', '<i class="fa fa-long-arrow-right fa-5x"></i>'],
	pagination: true,
	transitionStyle : "fade"
	});
});
</script>
<script type="text/javascript">
	// Can also be used with $(document).ready()
	$(window).load(function() {		
	  $("#spinner").fadeOut("slow");
	});	
</script>