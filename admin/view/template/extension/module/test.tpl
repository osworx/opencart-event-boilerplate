<?php>
/**
 * @version		$Id: test.tpl 2022-3-16 12:48Z mic $
 * @package		Boilerplate for event in OpenCart 2.x
 * @author		mic - https://osworx.net
 * @copyright	2022 OSWorX
 * @license		MIT
 */
echo $header . $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a id="submit" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $button_save; ?>"><i class="fa fa-save"></i></a>
				<a id="apply" class="btn btn-success" data-toggle="tooltip" title="<?php echo $btn_apply; ?>"><i class="fa fa-check-circle-o"></i></a>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<ul class="breadcrumb">
				<?php foreach( $breadcrumbs as $breadcrumb ) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if( $error_warning ) { ?>
			<div class="alert alert-danger">
				<i class="fa fa-exclamation-circle"></i>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo $error_warning; ?>
			</div>
		<?php } ?>
		<?php if( $success ) { ?>
			<div class="alert alert-success"><i class="fa fa-check-circle"></i>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo $success; ?>
			</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-robots-setting" class="form-horizontal">
					{# note: tabs are not required for simple extensions #}
					<ul class="nav nav-tabs">
						<li class="tab-setting active"><a href="#tab-setting" data-toggle="tab" data-tip="tooltip" title="<?php echo $help_tab_setting; ?>"><i class="fa fa-cog"></i> <?php echo $tab_setting; ?></a></li>
						<li class="tab-second"><a href="#tab-second" data-toggle="tab" data-tip="tooltip" title="<?php echo $help_tab_second; ?>"><i class="fa fa-file-text-o"></i> <?php echo $tab_second; ?></a></li>
					</ul>
					<div class="tab-content">
						<!-- tab 1 -->
						<div id="tab-setting" class="tab-pane fade in active">
							<div class="well well-sm"><?php echo $help_setting; ?></div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="<?php echo $help_status; ?>"><?php echo $entry_status; ?></span></label>
								<div class="col-sm-4">
									<div class="btn-group btn-group-custom" data-toggle="buttons">
										<label class="btn btn-success btn-sm<?php echo $cfg['status'] ? ' active' : ''; ?>">
											<input type="radio" id=""input-status" name="cfg[status]" value="1"<?php echo $cfg['status'] ? ' checked' : ''; ?> />
											<?php echo $text_enabled; ?>
										</label>
										<label class="btn btn-success btn-sm<?php echo !$cfg['status'] ? ' active' : ''; ?>">
											<input type="radio" name="cfg[status]" value="0"<?php echo !$cfg['status'] ? ' checked' : ''; ?> class="form-control" />
											<?php echo $text_disabled; ?>
										</label>
									</div>
								</div>
							</div>
                        </div>
						<!-- tab 2 -->
                        <div id="tab-second" class="tab-pane fade">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-second"><span data-toggle="tooltip" title="<?php echo $help_second; ?>"><?php echo $entry_second; ?></span></label>
								<div class="col-sm-4">
									<div class="btn-group btn-group-custom" data-toggle="buttons">
										<label class="btn btn-success btn-sm<?php echo $cfg['second'] ? ' active' : '' }}">
											<input type="radio" name="cfg[second]" id="input-second" value="1"<?php echo $cfg['second'] ? ' checked' : ''; ?> />
											<?php echo $text_bold; ?>
										</label>
										<label class="btn btn-success btn-sm<?php echo !$cfg['second'] ? ' active' : ''; ?>">
											<input type="radio" name="cfg[second]" value="0"<?php echo !$cfg['second'] ? ' checked' : ''; ?> class="form-control" />
											<?php echo $text_italic; ?>
										</label>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
	/* add here possible style definitions - not mandatory */
	form label{font-weight:normal}
	.form-group{margin-bottom:0; padding-bottom:15px; padding-top:15px}
	.form-group + .form-group{border-top:1px solid #ededed}
	.btn-success{background-color:#fff; color:#000; border-color:#ddd}
	.btn:hover{background-color:#2CB6C5}
	.nav-tabs li a span {padding-left:7px}
	.alert-inline{margin-bottom:0px; margin-top:10px}
	label > input.radio-image{visibility:hidden; position:absolute}
	label > input + img {cursor:pointer; border:1px solid transparent}
	label > input:checked + img{border:1px solid#2398B5}
</style>
<script>
	let $form = '#' + $('form').attr('id'), $token = '&token={{ token }}', $route = 'index.php?route={{ _route }}';

	$(function() {
		$('[data-tip="tooltip"]').tooltip({trigger:'hover'});
	})

	$('#apply').on('click',function() {
		$($form).append('<input type="hidden" name="mode" value="apply" />');
		$('#submit').trigger('click');
	})

	$('#submit').on('click',function() {
		$($form).submit();
	})

    /* add here further needed functions, etc. */
	/* 1 example: an ajax call to show how vars are used
	$('.tab-second').on('click', function() {
		$.ajax({
			url : $route + '/loadTabsecond' + $token
		}).done( function(json) {
			$('#tab-second').html(json);
		});
	})
	*/
</script>
