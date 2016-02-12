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
?><div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">    
      <div class="panel panel-primary">
        <div class="panel-heading"> Quick quote in 2 easy steps </div>
        <div class="panel-body">
        
<?php if (isset($step2)) { ?>
			<div class="backlink"><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Front:Default:default"), ENT_COMPAT) ?>" class="btn btn-primary backBtn"> << Back to step 1</a></div>
      <div class="storeDetails"><p class="lead">This is an example of shops name.</p>
<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec justo diam, elementum a ultricies et, volutpat sed urna. Donec id fermentum turpis. Mauris lobortis tincidunt augue quis dictum. In eu ligula at sapien volutpat consectetur. Praesent nec consectetur mi, nec lacinia augue.
<a href="#">Show more...</a>   </p>
<img class="storeImage" src="http://www.herringtonstorage.co.uk/userfiles/image/Category_Images/Storage-box-warehouse.jpg">
</div>
<?php $_l->tmp = $_control->getComponent("customerForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;} else { ?>
			
		<div class="row">
			<div class="col-md-6"> 
<?php $_l->tmp = $_control->getComponent("quoteForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
			</div> 
			<div class="col-md-6"> 
			
			</div> 
		</div>
		
        </div>
     

          <div class="panel-footer">  </div>
       </div>
    </div>
  </div>
</div>        
        
<?php } ?>

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
?>

<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>





<?php
}}