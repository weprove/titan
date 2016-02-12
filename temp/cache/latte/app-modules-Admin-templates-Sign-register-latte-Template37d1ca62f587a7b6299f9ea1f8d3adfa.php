<?php
// source: C:\wamp\www\titan\app\modules\Admin/templates/Sign/register.latte

class Template37d1ca62f587a7b6299f9ea1f8d3adfa extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('cad004da59', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbae94b8ef5b_content')) { function _lbae94b8ef5b_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<div class="row">
		<div class="signWrapper">
			<div id="signUpForm" class="panel panel-default">
				<div class="sign_logo">Sign logo</div>
				<div class="panel-heading">Create your Titan Storage account</div>
				<div class="panel-body">
<?php $iterations = 0; foreach ($flashes as $flash) { ?>					<div<?php if ($_l->tmp = array_filter(array('flash', $flash->type))) echo ' class="' . Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>
><?php echo Latte\Runtime\Filters::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; } ?>
					<p>
						Sample notice...
					</p>
<?php $_l->tmp = $_control->getComponent("registerForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render('begin') ;$_l->tmp = $_control->getComponent("registerForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render('errors') ;$form = $control['registerForm'] ?>
						<fieldset>
							<div class="form-group">
								<?php echo Latte\Runtime\Filters::escapeHtml($form['name']->control, ENT_NOQUOTES) ?>

							</div>
							
							<div class="form-group">
								<?php echo Latte\Runtime\Filters::escapeHtml($form['surname']->control, ENT_NOQUOTES) ?>

							</div>
							
							<div class="form-group">
								<?php echo Latte\Runtime\Filters::escapeHtml($form['email']->control, ENT_NOQUOTES) ?>

							</div>
							
							<div class="form-group">
								<?php echo Latte\Runtime\Filters::escapeHtml($form['password']->control, ENT_NOQUOTES) ?>

							</div>
							
							<div class="form-group">
								<?php echo Latte\Runtime\Filters::escapeHtml($form['passwordCheck']->control, ENT_NOQUOTES) ?>

							</div>
							<?php echo Latte\Runtime\Filters::escapeHtml($form['submitter']->control, ENT_NOQUOTES) ?>

						<fieldset>
<?php $_l->tmp = $_control->getComponent("registerForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render('end') ?>
				</div>
			</div>
		</div>
	</div>
<?php
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lbe660913c88_scripts')) { function _lbe660913c88_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;Latte\Macros\BlockMacrosRuntime::callBlockParent($_b, 'scripts', get_defined_vars()) ;
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

<?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars()) ; 
}}