<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $return; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?php echo $text_author; ?></label>
            <div class="col-sm-8"><?php echo $author; ?></div>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?php echo $text_email; ?></label>
            <div class="col-sm-8"><?php echo $email; ?></div>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?php echo $text_date_added; ?></label>
            <div class="col-sm-8"><?php echo $date_added; ?></div>
          </div>
        </div>
        <div class="tab-content">
          <ul class="nav nav-tabs" id="language">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <?php foreach ($languages as $language) { ?>
            <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
              <div class="form-group">
                <label class="col-sm-2 control-label text-right"><?php echo $text_comment; ?></label>
                <div class="col-sm-10">
                  <?php echo isset($comment_descriptions[$language['language_id']]) ? $comment_descriptions[$language['language_id']]['comment'] : ''; ?>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script>
<?php echo $footer; ?>