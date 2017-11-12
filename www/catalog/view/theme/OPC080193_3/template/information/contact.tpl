<?php echo $header; ?>
<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <h1 class="page-title"><?php echo $heading_title; ?></h1>
            <h3><?php echo $text_location; ?></h3>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="contact-info">
                        <div class="left">
                            <?php if ($image) { ?>
                            <div class="address-detail"><img src="<?php echo $image; ?>" alt="<?php echo $store; ?>"
                                                             title="<?php echo $store; ?>" class="img-thumbnail"/></div>
                            <?php } ?>
                            <div class="address-detail">
                                <i class="fa fa-industry"></i>
                                <strong><?php echo $store; ?></strong>
                                <address> <?php echo $address; ?></address>
                                <?php if ($geocode) { ?>
                                <a href="https://maps.google.com/maps?q=<?php echo urlencode($geocode); ?>&hl=<?php echo $geocode_hl; ?>&t=m&z=15"
                                   target="_blank" class="btn btn-info"><i
                                            class="fa fa-map-marker"></i> <?php echo $button_map; ?></a>
                                <?php } ?>
                            </div>
                            <div class="telephone">
                                <i class="fa fa-phone-square"></i>
                                <strong><?php echo $text_telephone; ?></strong>
                                <address><?php echo $telephone; ?> </address>
                            </div>
                            <div class="fax">
                                <?php if ($fax) { ?>
                                <i class="fa fa-fax"></i>
                                <strong><?php echo $text_fax; ?></strong>
                                <address><?php echo $fax; ?></address>
                                <?php } ?>

                            </div>
                            <div class="open-time">
                                <?php if ($open) { ?>
                                <i class="fa fa-clock-o"></i>
                                <strong><?php echo $text_open; ?></strong>
                                <address><?php echo $open; ?></address>
                                <?php } ?>
                            </div>
                            <div class="comment">
                                <?php if ($comment) { ?>
                                <i class="fa fa-bullhorn"></i>
                                <strong><?php echo $text_comment; ?></strong>
                                <address><?php echo $comment; ?></address>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="right">
                            <div class="map">
                                <?php /*?><?php
						$geo=explode(',',$geocode);
						print_r($geo);
						echo count($geo);
						if(count($geo)==2){
								echo "yes";
						}
						else{
								echo "no";
						}
					?><?php */?>
                                <script type="text/javascript"
                                        src="http://www.webestools.com/google_map_gen.js?lati=50.004604&long=36.235439&zoom=17&width=550&height=400&mapType=normal&map_btn_normal=yes&map_btn_satelite=yes&map_btn_mixte=yes&map_small=yes&marqueur=yes&info_bulle="></script><br /><a href="http://www.webestools.com/google-maps-code-generator-insert-map-on-website-javascript-free-google-map-script.html"></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php if ($locations) { ?>
            <h3><?php echo $text_store; ?></h3>
            <div class="panel-group" id="accordion">
                <?php foreach ($locations as $location) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a href="#collapse-location<?php echo $location['location_id']; ?>"
                                                   class="accordion-toggle" data-toggle="collapse"
                                                   data-parent="#accordion"><?php echo $location['name']; ?> <i
                                        class="fa fa-caret-down"></i></a></h4>
                    </div>
                    <div class="panel-collapse collapse" id="collapse-location<?php echo $location['location_id']; ?>">
                        <div class="panel-body">
                            <div class="row">
                                <?php if ($location['image']) { ?>
                                <div class="col-sm-3"><img src="<?php echo $location['image']; ?>"
                                                           alt="<?php echo $location['name']; ?>"
                                                           title="<?php echo $location['name']; ?>"
                                                           class="img-thumbnail"/></div>
                                <?php } ?>
                                <div class="col-sm-3"><strong><?php echo $location['name']; ?></strong><br/>
                                    <address>
                                        <?php echo $location['address']; ?>
                                    </address>
                                    <?php if ($location['geocode']) { ?>
                                    <a href="https://maps.google.com/maps?q=<?php echo urlencode($location['geocode']); ?>&hl=<?php echo $geocode_hl; ?>&t=m&z=15"
                                       target="_blank" class="btn btn-info"><i
                                                class="fa fa-map-marker"></i> <?php echo $button_map; ?></a>
                                    <?php } ?>
                                </div>

                                <div class="col-sm-3"><strong><?php echo $text_telephone; ?></strong><br>
                                    <?php echo $location['telephone']; ?><br/>
                                    <br/>
                                    <?php if ($location['fax']) { ?>
                                    <strong><?php echo $text_fax; ?></strong><br>
                                    <?php echo $location['fax']; ?>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-3">
                                    <?php if ($location['open']) { ?>
                                    <strong><?php echo $text_open; ?></strong><br/>
                                    <?php echo $location['open']; ?><br/>
                                    <br/>
                                    <?php } ?>
                                    <?php if ($location['comment']) { ?>
                                    <strong><?php echo $text_comment; ?></strong><br/>
                                    <?php echo $location['comment']; ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <fieldset>
                    <h3><?php echo $text_contact; ?></h3>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="<?php echo $name; ?>" id="input-name"
                                   class="form-control"/>
                            <?php if ($error_name) { ?>
                            <div class="text-danger"><?php echo $error_name; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="email" value="<?php echo $email; ?>" id="input-email"
                                   class="form-control"/>
                            <?php if ($error_email) { ?>
                            <div class="text-danger"><?php echo $error_email; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
                        <div class="col-sm-10">
                            <textarea name="enquiry" rows="10" id="input-enquiry"
                                      class="form-control"><?php echo $enquiry; ?></textarea>
                            <?php if ($error_enquiry) { ?>
                            <div class="text-danger"><?php echo $error_enquiry; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php echo $captcha; ?>
                </fieldset>
                <div class="buttons">
                    <div class="pull-right">
                        <input class="btn btn-primary" type="submit" value="<?php echo $button_submit; ?>"/>
                    </div>
                </div>
            </form>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
