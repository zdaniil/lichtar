<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>

<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Raleway:400,400i,300,500,700,900" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Roboto:400,500,700,900,300" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/stylesheet.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/megnor/carousel.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/megnor/custom.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/megnor/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/megnor/lightbox.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/megnor/animate.css" />

<?php if($direction=='rtl'){ ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/megnor/rtl.css">
<?php }?>

<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<!-- Megnor www.templatemela.com - Start -->
<script type="text/javascript" src="catalog/view/javascript/megnor/custom.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/jstree.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/carousel.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/megnor.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/jquery.custom.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/jquery.formalize.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/jquery.elevatezoom.min.js"></script>  
<script type="text/javascript" src="catalog/view/javascript/lightbox/lightbox-2.6.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/tabs.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/bootstrap-notify.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/doubletaptogo.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/parallex.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/video4all.js"></script>
<!-- Megnor www.templatemela.com - End -->

<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
	<?php foreach ($links as $link) { ?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
	<?php } ?>

<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>			
</head>

<?php if ($column_left && $column_right) { ?>
<?php $layoutclass = 'layout-3'; ?>
<?php } elseif ($column_left || $column_right) { ?>
<?php if ($column_left){ ?>
<?php $layoutclass = 'layout-2 left-col'; ?>
<?php } elseif ($column_right) { ?>
<?php $layoutclass = 'layout-2 right-col'; ?>
<?php } ?>
<?php } else { ?>
<?php $layoutclass = 'layout-1'; ?>
<?php } ?>

<body class="<?php echo $class;echo " " ;echo $layoutclass; ?>">
<nav id="top">
  <div class="container">   
    
  </div>
</nav>
<header>
  <div class="container">
    <div class="row">
	 <div class="col-sm-4 header-left">
	<div class="phone"><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?> : </a> <span><?php echo $telephone; ?></span></div>
	</div>
      <div class="col-sm-4 header-logo">
        <div id="logo">
          <?php if ($logo) { ?>
          <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
          <?php } else { ?>
          <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
          <?php } ?>
        </div>
      </div>
	  <div class="col-sm-4 header-right">
	  <div class="header-right-container">
	  <div id="top-links" class="nav pull-right">
      <ul class="list-inline"> 
        <li class="dropdown myaccount"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown"> <span class="account-toggle"></span></a>
          <ul class="dropdown-menu dropdown-menu-right myaccount-menu">
            <?php if ($logged) { ?>
            <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
            <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
            <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
            <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
            <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
            <?php } else { ?>
            <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
            <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
            <?php } ?>
			<li><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_wishlist; ?></span></a></li>
        	<li><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_checkout; ?></span></a></li>
			<li class="lang_cur_block">
			<?php echo $language; ?>
			<?php echo $currency; ?>	
			</li>
          </ul>
        </li>
        
      </ul>
    </div>
	  <div class="col-sm-2 header-cart"><?php echo $cart; ?></div>
      <div class="header-search"><div class="search"><?php echo $search; ?></div>
      </div> 
	  </div>
	  </div>
    </div>
  </div>
</header>
<nav class="nav-container" role="navigation">
<div class="nav-inner">
<div class="container">
<!-- ======= Menu Code START ========= -->
<?php if ($categories) { ?>
<!-- Opencart 3 level Category Menu-->
<div id="menu" class="main-menu">

 <?php /*?><div class="navbar-header collapsed" data-toggle="collapse" data-target=".navbar-ex1-collapse"><span id="category" class="visible-xs"><?php echo $text_category; ?></span>
    </div><?php */?>
      <ul class="nav navbar-nav">
  	<li class="top_level"> <a href="<?php echo $home; ?>"><?php echo $text_home; ?></a></li>
    	<?php foreach ($categories as $category) { ?>
        <?php if ($category['children']) { ?>
			<li class="top_level dropdown"><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>

			<div class="dropdown-menu megamenu column<?php echo $category['column']; ?>">
            <div class="dropdown-inner">
              <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
				<ul class="list-unstyled childs_1">
                <?php foreach ($children as $child) { ?>
					<!-- 2 Level Sub Categories START -->
					<?php if ($child['childs']) { ?>
					  <li class="dropdown"><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>

						  <div class="dropdown-menu">
			              <div class="dropdown-inner">
			              <?php foreach (array_chunk($child['childs'], ceil(count($child['childs']) / $child['column'])) as $childs_col) { ?>
							<ul class="list-unstyled childs_2">
							  <?php foreach ($childs_col as $childs_2) { ?>
								<li><a href="<?php echo $childs_2['href']; ?>"><?php echo $childs_2['name']; ?></a></li>
							  <?php } ?>
							</ul>
						  <?php } ?>
						  </div>
						  </div>

					  </li>
					<?php } else { ?>
					  <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
					<?php } ?>
					<!-- 2 Level Sub Categories END -->
                <?php } ?>
              
			    </ul>
              <?php } ?>
            </div>
			</div>

			</li>
        <?php } else { ?>
			<li class="top_level"><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
        <?php } ?>
        <?php } ?>
	<?php if(isset($blog_enable)){   ?>
       	<li class="blog-link"> <a href="<?php echo $all_blogs; ?>"><?php echo $text_blog; ?></a></li>       
<?php  } ?>
  </ul>
  
</div>
<?php } ?>




<!-- Opencart 3 level Category Menu-->
<div id="res-menu" class="main-menu nav-container1">

<div class="nav-responsive"><span>Menu</span><div class="expandable"></div></div>
  <ul class="main-navigation">
    <?php foreach ($categories as $category) { ?>
    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
      <?php if ($category['children']) { ?>

        <?php for ($i = 0; $i < count($category['children']);) { ?>
        <ul>
          <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
         <?php for (; $i < count($category['children']); $i++) { ?>
          <?php if (isset($category['children'][$i])) { ?>										
				<li>
				<?php if(count($category['children'][$i]['childs'])>0){ ?>
					<a href="<?php echo $category['children'][$i]['href']; ?>" class="activSub" ><?php echo $category['children'][$i]['name'];?></a> 					
				<?php } else { ?>				
					<a href="<?php echo $category['children'][$i]['href']; ?>" ><?php echo $category['children'][$i]['name']; ?></a>
				<?php } ?>
				<?php if ($category['children'][$i]['childs']) { ?>
				<ul class="col<?php echo $j; ?>">
				<?php for ($wi = 0; $wi < count($category['children'][$i]['childs']); $wi++) { ?>
					<li><a href="<?php echo $category['children'][$i]['childs'][$wi]['href']; ?>"  ><?php echo $category['children'][$i]['childs'][$wi]['name']; ?></a></li>
				 <?php } ?>
				</ul>
			  <?php } ?>		  
			</li>		
          <?php } ?>
          <?php } ?>
        </ul>
        <?php } ?>
      <?php } ?>
    </li>
    <?php } ?>
	
	<?php if(isset($blog_enable)){   ?>
       	<li class="blog-link"> <a href="<?php echo $all_blogs; ?>"><?php echo $text_blog; ?></a></li>       
	<?php  } ?>
	
  </ul>
</div>

</div>

<!-- ======= Menu Code END ========= -->

</div>
</nav>   

<div class="content_headercms_top"><?php echo $headertop; ?> </div>
<div class="content-top-breadcum">
<div class="container">
<div class="row">
<div id="title-content"> 
</div>
</div>
</div>
</div>
