<?php
// source: C:\wamp\www\titan\app\modules\Admin/templates/Store/editStore.latte

class Template52185f4683f60b4b577b68bfab22e460 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('e0a49b2580', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb97af558736_content')) { function _lb97af558736_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<div class="row">
		<div class="col-md-12">
			<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Store:viewStores"), ENT_COMPAT) ?>" class="btn btn-primary backBtn"> << Go back </a>
		</div>
	</div>
	
	<div class="row">	
		<div class="col-md-12">
<?php $_l->tmp = $_control->getComponent("addStoreForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
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
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}