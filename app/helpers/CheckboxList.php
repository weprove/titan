<?php
use Nette\Utils\Html,
    Nette\Forms\Controls\BaseControl;
/**
 * Cloned RadioList from Nette Framework distribution. Instead of radios use
 * checkboxes.
 *
 * @copyright  Copyright (c) 2004, 2009 David Grudl
 * @license    http://nettephp.com/license  Nette license
 * @link       http://addons.nettephp.com/cs/checkboxlist
 * @package    Nette\Extras
 */

/**
 * CheckboxList
 *
 * @author    David Grudl, Jan Vlcek
 * @copyright Copyright (c) 2004, 2009 David Grudl
 * @package   Nette\Extras
 */
class CheckboxList extends BaseControl
{
	/** @var Nette\Web\Html  separator element template */
	protected $separator;

	/** @var Nette\Web\Html  container element template */
	protected $container;

	/** @var array */
	protected $items = array();

  private $baseLabel;

  protected function getBaseLabel()
  {
    if ($this->baseLabel === NULL)
      $this->baseLabel = /*Nette\Web\*/Html::el('label');
    return $this->baseLabel;
  }

	/**
	 * Form container extension method. Do not call directly.
	 * 	 
	 * @param FormContainer $form
	 * @param string $name
	 * @param string $label
	 * @param array $items	 
	 * @return CheckboxList
	 */
	public static function addCheckboxList(\Nette\Forms\Container $form, $name, $label, array $items = NULL)
	{
		return $form[$name] = new self($label, $items);
	}



	/**
	 * @param string $label
	 * @param array $items  Options from which to choose
	 */
	public function __construct($label, array $items = NULL)
	{
		parent::__construct($label);
		$this->control->type = 'checkbox';
		$this->container = Html::el();
		$this->separator = Html::el('br');
		if ($items !== NULL) $this->setItems($items);
	}



	/**
	 * Returns selected radio value. NULL means nothing have been checked. 
	 * 	 
	 * @return mixed
	 */
	public function getValue()
	{
		return is_array($this->value) ? $this->value : NULL;
	}



	/**
	 * Sets options from which to choose.
	 * 	 
	 * @param array $items
	 * @return CheckboxList  provides a fluent interface
	 */
	public function setItems(array $items)
	{
		$this->items = $items;
		return $this;
	}



	/**
	 * Returns options from which to choose.
	 * 
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}



	/**
	 * Returns separator HTML element template.
	 * 	 
	 * @return Nette\Web\Html
	 */
	public function getSeparatorPrototype()
	{
		return $this->separator;
	}



	/**
	 * Returns container HTML element template.
	 * 	 
	 * @return Nette\Web\Html
	 */
	public function getContainerPrototype()
	{
		return $this->container;
	}



	/**
	 * Generates control's HTML element.
	 * 	 
	 * @param mixed $key  Specify a key if you want to render just a single checkbox
	 * @return Nette\Web\Html
	 */
	public function getControl($key = NULL)
	{
          if ($key === NULL) {
                        $container = clone $this->container;
                        $separator = (string) $this->separator;

                } elseif (!isset($this->items[$key])) {
                        return NULL;
                }

                $control = parent::getControl();
                $control->name .= '[]';
                $id = $control->id;
                $counter = -1;
                $values = $this->value === NULL ? NULL : (array) $this->getValue();
                $label = $this->getBaseLabel();

                foreach ($this->items as $k => $val) {
                        $counter++;
                        if ($key !== NULL && $key != $k) continue; // intentionally ==

                        $control->id = $label->for = $id . '-' . $counter;
                        $control->checked = (count($values) > 0) ? in_array($k, $values) : false;
                        $control->value = $k;

                        if ($val instanceof /*Nette\Web\*/Html) {
                                $label->setHtml($val);
                        } else {
                                $label->setText($this->translate($val));
                        }

                        if ($key !== NULL) {
                                return (string) $control;
                        }

                        $container->add((string) $control . (string) $label . $separator);
                }

                return $container;
	}



	/**
	 * Generates label's HTML element.
	 * 	 
	 * @return Html
	 */
public function getLabel($key = NULL)
{
        $control = parent::getControl();

        $id = $this->getHtmlId();
        $counter = -1;
        $label = /*Nette\Web\*/Html::el('label');

        foreach ($this->items as $k => $val) {
                $counter++;
                if ($key != $k) continue;
                $label->for = $id . '-' . $counter;

                if ($val instanceof /*Nette\Web\*/Html) {
                        $label->setHtml($val);
                } else {
                        $label->setText($this->translate($val));
                }

                return (string) $label;
        }
}

	/**
	 * Filled validator: has been any checkbox checked?
	 * 	 
	 * @param IFormControl $control
	 * @return bool
	 */
	public static function validateChecked(IFormControl $control)
	{
		return $control->getValue() !== NULL;
	}

}