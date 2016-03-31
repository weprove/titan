<?php
// source: C:\wamp\www\titan\titan\app\modules\Admin/templates/Store/viewStores.latte

class Template18e7d7c59179fe74bee532bb63c5afef extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('28ec35af43', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbc521b08f54_content')) { function _lbc521b08f54_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<div class="row"><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Store:addStore"), ENT_COMPAT) ?>" class="btn btn-primary adding"> Add new store </a></div>
<?php $_l->tmp = $_control->getComponent("storesGrid"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;
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