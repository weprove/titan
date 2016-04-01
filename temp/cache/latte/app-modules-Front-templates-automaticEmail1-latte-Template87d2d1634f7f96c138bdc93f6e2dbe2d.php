<?php
// source: C:\xampp\htdocs\titan\app\modules\Front/templates/automaticEmail1.latte

class Template87d2d1634f7f96c138bdc93f6e2dbe2d extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('10c4a42892', 'html')
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
Dear <?php echo Latte\Runtime\Filters::escapeHtml($name, ENT_NOQUOTES) ?> <?php echo Latte\Runtime\Filters::escapeHtml($surname, ENT_NOQUOTES) ?>


Thank you for your enquiry with Titan Storage Braintree - your local storage company.

Your quote is on the right and includes your 50% discount for the first month. If you decide to stay for less than a month you will still get this discount - all we ask is that you stay for a minimum of 14 days.

At Titan we are passionate about giving our customers the best possible range of services. We work hard to provide removals and storage solutions that are easy to understand, simple to put together and best of all, easy to afford.

Our expert staff are here to help you…

Choose the right storage solution. [hyperlink to size estimator on website] Whether you are moving home, heading off to university or even looking for a place to run your internet business, our trained staff are experts in storage and will be able to advise you on your space requirement in a matter of minutes.

Organise removals. [hyperlink to removals content on website]
We understand that your time is precious that is why our dedicated staff will help you organise van hire and removals so you don’t have to!

Keep your possessions protected. [hyperlink to security content on website] We have a variety of packaging materials available at each store to help keep your goods protected throughout their removals and storage life.

Manage your storage space. [hyperlink to relevant blog on website] We believe our storage solutions should adapt with our customer’s requirements, therefore, we allow customers to switch sizes whenever you need more or less storage space.

If you have any questions, want to reserve, or would like to drop in and see the store, call us on01376 743232.

I look forward to hearing from you soon.

Ed Leland

Store Manager

Titan Storage Solutions Braintree
www.titanstorage.co.uk - there should always be a website link in the email
<?php
}}