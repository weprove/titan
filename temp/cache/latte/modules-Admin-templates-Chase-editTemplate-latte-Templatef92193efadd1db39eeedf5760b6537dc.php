<?php
// source: C:\xampp\htdocs\titan\app\modules\Admin/templates/Chase/editTemplate.latte

class Templatef92193efadd1db39eeedf5760b6537dc extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('89658df7c2', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb3fe2050e20_scripts')) { function _lb3fe2050e20_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;Latte\Macros\BlockMacrosRuntime::callBlockParent($_b, 'scripts', get_defined_vars()) ?>
	<script>
		tinyMCE.init({
				mode : "specific_textareas",
				editor_selector : "mceEditor",
				editor_deselector : "mceNoEditor",
				content_css : <?php echo Latte\Runtime\Filters::escapeJs($basePath) ?>+"/css/email_editor_content.css",
		});
	</script>
<?php
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb08043fada1_content')) { function _lb08043fada1_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<div class="row">
		<div class="col-md-9">
<?php $_l->tmp = $_control->getComponent("editTemplateForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
		</div>
		
		<div class="col-md-3">
			<div class="container-fluid marginTop20">
				<div class="well">
					<strong>Legend</strong>
					<ul>
						<li>Cart id: {$data['cart_id']}</li>
						<li>Name: {$data['customerFirstname']}</li>
						<li>Surname: {$data['customerSurname']}</li>
						<li>Product name: {$data['productName']}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php
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
if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}