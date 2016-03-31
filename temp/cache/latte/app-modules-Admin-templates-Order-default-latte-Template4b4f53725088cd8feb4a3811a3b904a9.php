<?php
// source: C:\wamp\www\titan\titan\app\modules\Admin/templates/Order/default.latte

class Template4b4f53725088cd8feb4a3811a3b904a9 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('d6969fe757', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb8a68b54b9e_scripts')) { function _lb8a68b54b9e_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;Latte\Macros\BlockMacrosRuntime::callBlockParent($_b, 'scripts', get_defined_vars()) ?>
	<script type="text/javascript">
		$(function(){
			$(".viewOrderDialogTrigger").click(function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				$.ajax({
					url: url,
					success: function(data) {
					  $("#orderDetailDialog").html(data);
					  $("#orderDetailDialog").dialog();
					}
				});
			});
		});
	</script>
<?php
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbe898c13381_content')) { function _lbe898c13381_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>	<div id="orderDetailDialog"></div>
	
	<ul class="nav nav-tabs marginTop20">
		<li class="active"><a href="#today" data-toggle="tab">Today</a>
		</li>
		<li><a href="#yesterday" data-toggle="tab">Yesterday</a>
		</li>
		<li><a href="#recent" data-toggle="tab">Recent</a>
		</li>
		<li><a href="#completed" data-toggle="tab">Completed orders</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane fade in active" id="today">
<?php $_l->tmp = $_control->getComponent("todayOrdersGrid"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
		</div>
		<div class="tab-pane fade" id="yesterday">
<?php $_l->tmp = $_control->getComponent("yesterdayOrdersGrid"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
		</div>
		<div class="tab-pane fade" id="recent">
<?php $_l->tmp = $_control->getComponent("recentOrdersGrid"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
		</div>
		<div class="tab-pane fade" id="completed">
<?php $_l->tmp = $_control->getComponent("completedOrdersGrid"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
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
call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}