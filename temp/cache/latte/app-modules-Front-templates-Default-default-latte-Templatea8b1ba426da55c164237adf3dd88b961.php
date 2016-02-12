<?php
// source: C:\wamp\www\titan\app\modules\Front/templates/Default/default.latte

class Templatea8b1ba426da55c164237adf3dd88b961 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('27a401005e', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb2b2ac7fb34_content')) { function _lb2b2ac7fb34_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">    
      <div class="panel panel-primary">
        <div class="panel-heading"> Quick quote in 2 easy steps </div>
        <div class="panel-body">
        
<?php if (isset($step2)) { ?>
			
      <div class="row">
<div class="col-md-6" ><div class="backlink"><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Front:Default:default"), ENT_COMPAT) ?>" class="btn btn-primary backBtn"> << Back to step 1</a></div> 
<?php $_l->tmp = $_control->getComponent("customerForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
</div>		
 <div class="col-md-6" > 

      <div class="storeDetails"><p class="lead">This is an example of shops name.</p>
<img class="storeImage" src="http://www.herringtonstorage.co.uk/userfiles/image/Category_Images/Storage-box-warehouse.jpg"><p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec justo diam, elementum a ultricies et, volutpat sed urna. Donec id fermentum turpis. Mauris lobortis tincidunt augue quis dictum. In eu ligula at sapien volutpat consectetur. Praesent nec consectetur mi, nec lacinia augue.
<a href="#">Show more...</a>   </p>

</div></div>   
<?php } else { ?>
			
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