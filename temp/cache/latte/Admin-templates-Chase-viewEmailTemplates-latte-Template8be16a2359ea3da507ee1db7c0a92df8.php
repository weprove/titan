<?php
// source: C:\xampp\htdocs\titan\app\modules\Admin/templates/Chase/viewEmailTemplates.latte

class Template8be16a2359ea3da507ee1db7c0a92df8 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('ccbbe2caf0', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb005a69bbc1_content')) { function _lb005a69bbc1_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<a class="marginBottom20 btn btn-primary" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Chase:editTemplate"), ENT_COMPAT) ?>">Create new template</a>
<?php if (isset($teplates)&&count($templates)>0) { ?>
		<ul>
<?php $iterations = 0; foreach ($templates AS $template) { ?>
				<li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Chase:editTemplate", array($template->template_id)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($template->templateName, ENT_NOQUOTES) ?></a></li>
<?php $iterations++; } ?>
		</ul>
<?php } else { ?>
			There are currently no email templates.
<?php } 
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