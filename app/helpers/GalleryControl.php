<?php
class Gallery extends Nette\Application\UI\Control
{
    private $images;
	public $disable_gallery_actions = false;

    public function __construct($images)
    {
		$this->images = $images;
    }
	
	public function render()
	{
		// šablonu není potřeba ručně vytvářet
		$this->template->setFile(__DIR__ . '/templates/gallery.latte');
		$this->template->images = $this->images;
		$this->template->disable_gallery_actions = $this->disable_gallery_actions;
		$this->template->render();
    }
}