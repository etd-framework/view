<?php
/**
 * Part of the ETD Framework View Package
 *
 * @copyright   Copyright (C) 2016 ETD Solutions, SARL Etudoo. Tous droits réservés.
 * @license     Apache License 2.0; see LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

namespace EtdSolutions\View;

use EtdSolutions\Model\Model;
use Joomla\DI\ContainerAwareInterface;
use Joomla\DI\ContainerAwareTrait;
use Joomla\Renderer\RendererInterface;
use Joomla\View\BaseHtmlView;

/**
 * Vue HTML
 */
class HtmlView extends BaseHtmlView implements ContainerAwareInterface {

    use ContainerAwareTrait;

    /**
     * The model object.
	 *
	 * @var Model
	 */
	protected $model;

	/**
	 * Method to instantiate the view.
	 *
	 * @param  Model              $model     The model object.
	 * @param  RendererInterface  $renderer  The renderer object.
	 */
	public function __construct(Model $model, RendererInterface $renderer) {

		parent::__construct($renderer);

		$this->model = $model;

	}

    /**
     * Method to render the view.
     *
     * @return  string  The rendered view.
     */
    public function render() {
        return $this->getRenderer()->render($this->getLayout() . $this->getContainer()->get('config')->get('template.extension'), $this->getData());
    }

}
