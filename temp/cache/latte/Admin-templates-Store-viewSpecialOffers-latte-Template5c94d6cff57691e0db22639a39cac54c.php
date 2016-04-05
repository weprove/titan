<?php
// source: C:\xampp\htdocs\titan\app\modules\Admin/templates/Store/viewSpecialOffers.latte

class Template5c94d6cff57691e0db22639a39cac54c extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('985d641e25', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb0be795eaf0_content')) { function _lb0be795eaf0_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<div class="row"><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Store:addSpecialOffer", array($store_id)), ENT_COMPAT) ?>" class="btn btn-primary adding"> Add new special offer </a></div>
<?php $_l->tmp = $_control->getComponent("specialOffersGrid"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;
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