<?php
// source: C:\wamp\www\titan\app\modules\Admin/templates/Store/viewProducts.latte

class Template0b9d2153234e36321e6e5e482d8dd76d extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5304e43428', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb23f0b5454f_content')) { function _lb23f0b5454f_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="row"><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Store:addProduct"), ENT_COMPAT) ?>" class="btn btn-primary adding"> Add new product</a>	
<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Store:viewStores"), ENT_COMPAT) ?>" class="btn btn-primary backBtn adding"> << Go back</a>
	 </div>
<?php $_l->tmp = $_control->getComponent("productsGrid"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;
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