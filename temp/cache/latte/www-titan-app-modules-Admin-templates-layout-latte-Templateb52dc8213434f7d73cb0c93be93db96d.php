<?php
// source: C:\wamp\www\titan\app\modules\Admin/templates/@layout.latte

class Templateb52dc8213434f7d73cb0c93be93db96d extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('d2d6d9da66', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block css
//
if (!function_exists($_b->blocks['css'][] = '_lb0a32bbdc74_css')) { function _lb0a32bbdc74_css($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/jquery-ui.min.css" rel="stylesheet">	
		<link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/jquery-ui.theme.min.css" rel="stylesheet">
		<link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/jquery.bxslider.css" rel="stylesheet">
		<link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen">
		<!-- MetisMenu CSS -->
		<link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/metisMenu.min.css" rel="stylesheet">
		<!-- Timeline CSS -->
		<link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/timeline.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/sb-admin-2.css" rel="stylesheet">
		<!-- Morris Charts CSS -->
		<link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/morris.css" rel="stylesheet">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/style.css">
<?php
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lbcde85a99e3_scripts')) { function _lbcde85a99e3_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery-ui.min.js"></script>
		<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery-ui-timepicker-addon.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="//nette.github.io/resources/js/netteForms.min.js"></script>
		<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/main.js"></script>
		<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/nette.ajax.js"></script>
		<script>$(function(){ $.nette.init(); });</script>
		<script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery.fancybox.pack.js?v=2.1.5"></script>
		<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery.bxslider.min.js"></script>
		<script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/tinymce/tinymce.min.js"></script>
		<!-- Metis Menu Plugin JavaScript -->
		<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/metisMenu/metisMenu.min.js"></script>
		<!-- Morris Charts JavaScript -->
		<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/raphael/raphael-min.js"></script>
		<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/morrisjs/morris.min.js"></script>
		<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/morris-data.js"></script>
		<!-- Custom Theme JavaScript -->
		<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/sb-admin-2.js"></script>	
		<script type="text/javascript">
			var contentChanged = false;
			
			tinyMCE.init({
					mode : "specific_textareas",
					editor_selector : "mceEditor",
					plugins: 'link',
					language : 'en',
					editor_deselector : "mceNoEditor",
					setup : function(ed) {
						  ed.on('change', function(ed) {
								  contentChanged = true;
						  });
					},
					content_css : <?php echo Latte\Runtime\Filters::escapeJs($basePath) ?>+"/css/editor_content.css",

			});
		</script>
<?php
}}

//
// block head
//
if (!function_exists($_b->blocks['head'][] = '_lb2f95a2371c_head')) { function _lb2f95a2371c_head($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// block _flashes
//
if (!function_exists($_b->blocks['_flashes'][] = '_lbc7042f161f__flashes')) { function _lbc7042f161f__flashes($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('flashes', FALSE)
?>					<div class="col-md-12">
<?php $iterations = 0; foreach ($flashes as $flash) { ?>						<div<?php if ($_l->tmp = array_filter(array('flash', $flash->type))) echo ' class="' . Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>
><?php echo Latte\Runtime\Filters::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; } ?>
					</div>
<?php
}}

//
// block scripts2
//
if (!function_exists($_b->blocks['scripts2'][] = '_lbcc48e20a93_scripts2')) { function _lbcc48e20a93_scripts2($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// end of blocks
//

// template extending

$_l->extends = empty($_g->extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $_g->extended = TRUE;

if ($_l->extends) { ob_start();}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIMacros::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<title><?php if (isset($_b->blocks["title"])) { ob_start(); Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'title', $template->getParameters()); echo $template->striptags(ob_get_clean()) ?>
 | <?php } ?>Titan Storage</title>
<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['css']), $_b, get_defined_vars())  ?>
	
	<link rel="shortcut icon" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/favicon.ico">
	
<?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>
	<meta name="viewport" content="width=device-width">
	<?php call_user_func(reset($_b->blocks['head']), $_b, get_defined_vars())  ?>

</head>

<body>	

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
<?php $_b->templates['d2d6d9da66']->renderChildTemplate("navbarHeader.latte", $template->getParameters()) ?>

<?php $_b->templates['d2d6d9da66']->renderChildTemplate("topBar.latte", $template->getParameters()) ?>
			
<?php $_b->templates['d2d6d9da66']->renderChildTemplate("sidebar.latte", $template->getParameters()) ?>
        </nav>

        <div id="page-wrapper">
			<div class="row">
<div id="<?php echo $_control->getSnippetId('flashes') ?>"><?php call_user_func(reset($_b->blocks['_flashes']), $_b, $template->getParameters()) ?>
</div>			</div>
			
			<div class="container-fluid">
<?php Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'content', $template->getParameters()) ?>
			</div>
			
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	
	
<?php call_user_func(reset($_b->blocks['scripts2']), $_b, get_defined_vars())  ?>
</body>
</html>
<?php
}}