<?php
// source: C:\xampp\htdocs\titan\app\modules\Admin/templates/sidebar.latte

class Templated5133f3693b7636aa9f93a05edf9f2b8 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('c9bf5b47f7', 'html')
;
// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIMacros::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
?>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Default:default"), ENT_COMPAT) ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
						<li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Store:viewStores"), ENT_COMPAT) ?>"><i class="fa fa-institution fa-fw"></i> Stores</a>
                        </li>
						<li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Order:"), ENT_COMPAT) ?>"><i class="fa fa-shopping-cart fa-fw"></i> Orders</a>
                        </li>
						<li>
                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Admin:Chase:"), ENT_COMPAT) ?>"><i class="fa fa-user fa-fw"></i> Chasing clients</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
			<!-- /.navbar-static-side --><?php
}}