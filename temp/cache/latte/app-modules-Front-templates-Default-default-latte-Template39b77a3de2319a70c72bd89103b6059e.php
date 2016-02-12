<?php
// source: C:\xampp\htdocs\titan\app\modules\Front/templates/Default/default.latte

class Template39b77a3de2319a70c72bd89103b6059e extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('f7362ef087', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb92a73d93f9_content')) { function _lb92a73d93f9_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>		:Front:Default:default (muzes smazat)
			
<?php if (isset($step2)) { ?>
			<a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Front:Default:default"), ENT_COMPAT) ?>" class="btn btn-primary"> << Back to step 1</a>
<?php $_l->tmp = $_control->getComponent("customerForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;} else { $_l->tmp = $_control->getComponent("quoteForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;} 
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