<?php
// source: C:\xampp\htdocs\titan\app\modules\Admin/templates/Chase/viewSentEmail.latte

class Template4deb0e5399cf89e93cbd9efb9e262e1a extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('0d88f0f225', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb57ca8f925d_content')) { function _lb57ca8f925d_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<div class="row marginTop30">
		<div class="col-md-12">
			<a href="javascript:this.close();" class="btn btn-primary ">Close</a>
			<?php echo $content ?>

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
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>





<?php
}}