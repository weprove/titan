<?php
class VideoGallery extends Nette\Application\UI\Control
{
    private $videos;
	public $disable_gallery_actions = false;

    public function __construct($videos)
    {
		$this->videos = $videos;
    }
	
	public function render()
	{
		// šablonu není potřeba ručně vytvářet
		$this->template->setFile(__DIR__ . '/templates/videoGallery.latte');
		$this->template->videos = $this->videos;
		$this->template->disable_gallery_actions = $this->disable_gallery_actions;
		$this->template->render();
    }
}