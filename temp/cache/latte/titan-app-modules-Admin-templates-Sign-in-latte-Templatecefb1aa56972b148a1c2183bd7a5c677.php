<?php
// source: C:\xampp\htdocs\titan\app\modules\Admin/templates/Sign/in.latte

class Templatecefb1aa56972b148a1c2183bd7a5c677 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('0e10d77a10', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb828fd6a92e_content')) { function _lb828fd6a92e_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<div class="row">
		<div class="signWrapper">
			<div id="signInForm" class="panel panel-default">
				<div class="sign_logo"></div>
				<div class="panel-heading">
        
         <div class="row">
<div class="col-md-4"><img id="logo-login" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/images/titan-logo-mini.png"></div>
<div class="col-md-8 title-login"><h3 class="panel-title">
						Sign in to your account
					</h3></div>
</div>
        
				
				</div>
				<div class="panel-body">
<?php $iterations = 0; foreach ($flashes as $flash) { ?>					<div<?php if ($_l->tmp = array_filter(array('flash', $flash->type))) echo ' class="' . Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>
><?php echo Latte\Runtime\Filters::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; } $_l->tmp = $_control->getComponent("loginForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render('begin') ;$_l->tmp = $_control->getComponent("loginForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render('errors') ;$form = $control['loginForm'] ?>
						<fieldset>
							<div class="form-group">
								<?php echo Latte\Runtime\Filters::escapeHtml($form['username']->control, ENT_NOQUOTES) ?>

							</div>
							
							<div class="form-group">
								<?php echo Latte\Runtime\Filters::escapeHtml($form['password']->control, ENT_NOQUOTES) ?>

							</div>
							
							<div class="checkbox">
								<?php echo Latte\Runtime\Filters::escapeHtml($form['remember']->control, ENT_NOQUOTES) ;echo Latte\Runtime\Filters::escapeHtml($form['remember']->label, ENT_NOQUOTES) ?>

								<a class="forgottenPw" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Sign:lostPassword"), ENT_COMPAT) ?>">Forgotten password?</a>
							</div>

							<?php echo Latte\Runtime\Filters::escapeHtml($form['login']->control, ENT_NOQUOTES) ?>

						<fieldset>
<?php $_l->tmp = $_control->getComponent("loginForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render('end') ?>
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
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}