<?php
// source: C:\xampp\htdocs\titan\app\modules\Admin/templates/Default/viewUsers.latte

class Templateedb0849a89647e1b2fad4f96ef750fb4 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('ba773094cc', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb9b1037648f_content')) { function _lb9b1037648f_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>		<div class="row"><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Default:addUser"), ENT_COMPAT) ?>" class="btn btn-primary adding"> Add new user </a></div>
<?php $_l->tmp = $_control->getComponent("usersGrid"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;
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