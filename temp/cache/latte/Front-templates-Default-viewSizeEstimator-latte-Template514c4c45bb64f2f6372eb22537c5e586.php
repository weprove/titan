<?php
// source: C:\xampp\htdocs\titan\app\modules\Front/templates/Default/viewSizeEstimator.latte

class Template514c4c45bb64f2f6372eb22537c5e586 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('cd57fed4cb', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lbaae0ddf239_scripts')) { function _lbaae0ddf239_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;Latte\Macros\BlockMacrosRuntime::callBlockParent($_b, 'scripts', get_defined_vars()) ;
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb0248279208_content')) { function _lb0248279208_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="container">
	<div class="row">
		<div class="col-md-12">    
		 </div>	
	</div> <!-- row end-->
		
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
call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>


<?php call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>





<?php
}}