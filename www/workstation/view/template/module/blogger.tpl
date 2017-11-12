<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-blogger" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_view_list; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>   
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-blogger" class="form-horizontal">
          <input type="hidden" name="module_id" value="<?php echo $module_id; ?>" />
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-8">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-8">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-width"><span data-toggle="tooltip" title="<?php echo $help_image; ?>"><?php echo $entry_image_size; ?></span></label>
            <div class="col-sm-4">
              <input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
              <?php if ($error_width) { ?>
              <div class="text-danger"><?php echo $error_width; ?></div>
              <?php } ?>
            </div>
            <div class="col-sm-4">
              <input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
              <?php if ($error_height) { ?>
              <div class="text-danger"><?php echo $error_height; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-limit"><span data-toggle="tooltip" title="<?php echo $help_limit; ?>"><?php echo $entry_limit; ?></span></label>
            <div class="col-sm-8">
              <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-char-limit"><span data-toggle="tooltip" title="<?php echo $help_char_limit; ?>"><?php echo $entry_char_limit; ?></span></label>
            <div class="col-sm-8">
              <input type="text" name="char_limit" value="<?php echo $char_limit; ?>" placeholder="<?php echo $entry_char_limit; ?>" id="input-char-limit" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $help_allow_comments; ?>"><?php echo $entry_allow_comments; ?></span></label>
            <div class="col-sm-8">
              <label class="radio-inline">
                <?php if ($comments) { ?>
                <input type="radio" name="comments" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="comments" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if (!$comments) { ?>
                <input type="radio" name="comments" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="comments" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $help_login_required; ?>"><?php echo $entry_login_required; ?></span></label>
            <div class="col-sm-8">
              <label class="radio-inline">
                <?php if ($login) { ?>
                <input type="radio" name="login" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="login" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if (!$login) { ?>
                <input type="radio" name="login" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="login" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $help_auto_approve; ?>"><?php echo $entry_auto_approve; ?></span></label>
            <div class="col-sm-8">
              <label class="radio-inline">
                <?php if ($auto_approve) { ?>
                <input type="radio" name="auto_approve" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="auto_approve" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if (!$auto_approve) { ?>
                <input type="radio" name="auto_approve" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="auto_approve" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
            </div>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left"><?php echo $column_title; ?></td>
                <td class="text-left"><?php echo $column_status; ?></td>
                <td class="text-right"><?php echo $column_comments; ?></td>
                <td class="text-right"><?php echo $column_date_added; ?></td>
                <td class="text-right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <?php if ($blogger_entries) { ?>
            <tbody>
              <?php foreach ($blogger_entries as $entry) { ?>
              <tr>
                <td class="text-left"><?php echo $entry['title']; ?></td>
                <td class="text-left"><?php echo $entry['status']; ?></td>
                <td class="text-right"><?php echo $entry['total_comments']; ?></td>
                <td class="text-right"><?php echo $entry['date_added']; ?></td>
                <td class="text-right">
                  <a onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $entry['delete']; ?>' : false;" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a>
                  <a href="<?php echo $entry['comments']; ?>" data-toggle="tooltip" title="<?php echo $button_comments; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                  <a href="<?php echo $entry['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                  </td>
              </tr>
              <?php } ?>
            </tbody>
            <?php } ?>
            <tfoot>
              <?php if ($add_blog) { ?>
              <tr>
                <td class="text-right" colspan="5"><button type="button" onclick="location = '<?php echo $add_blog; ?>';" data-toggle="tooltip" title="<?php echo $button_add_blog; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
              </tr>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="5"><?php echo $text_save_module; ?></td>
              </tr>
              <?php } ?>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>