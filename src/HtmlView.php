<?php
/**
 * Part of the ETD Framework View Package
 *
 * @copyright   Copyright (C) 2015 ETD Solutions, SARL Etudoo. Tous droits réservés.
 * @license     Apache License 2.0; see LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

namespace EtdSolutions\View;

use EtdSolutions\Application\Web;
use EtdSolutions\Document\Document;
use EtdSolutions\Model\Model;
use Joomla\Language\Text;
use Joomla\Model\AbstractModel;
use Joomla\View\AbstractHtmlView;

defined('_JEXEC') or die;

/**
 * Vue HTML
 */
class HtmlView extends AbstractHtmlView {

    /**
     * @var $name string Le nom de la vue.
     */
    protected $name;

    /**
     * @var $stylesheet string Le nom de la feuille de styles associées à la vue.
     */
    protected $stylesheet;

    /**
     * @var $defaultModel string Le nom du model par défaut.
     */
    protected $defaultModel;

    /**
     * @var Text
     */
    protected $text;

    public function __construct(AbstractModel $model = null, \SplPriorityQueue $paths = null) {

        $this->defaultModel = $this->getName();

        if (!isset($this->stylesheet)) {
            $this->stylesheet = strtolower($this->getName());
        }

        $this->text = Web::getInstance()
                         ->getText();

        $model = isset($model) ? $model : $this->getModel();

        parent::__construct($model, $paths);
    }

    /**
     * Method to load the paths queue.
     *
     * @return  \SplPriorityQueue  The paths queue.
     *
     * @since       1.0
     * @deprecated  2.0  In 2.0, a RendererInterface object will be required which will manage paths.
     */
    protected function loadPaths() {

        $paths = new \SplPriorityQueue;
        $paths->insert(JPATH_THEME . '/html/views/' . strtolower($this->getName()), 1);
        $paths->insert(JPATH_THEME . '/css/views/', 2);
        $this->paths = $paths;

        return $this->paths;
    }

    /**
     * Méthode pour charger un model.
     *
     * @param string $name           Le nom du modèle. Facultatif.
     * @param   bool $ignore_request Utilisé pour ignorer la mise à jour de l'état depuis l'input.
     *
     * @return AbstractModel Le modèle.
     *
     * @throws \RuntimeException
     */
    protected function getModel($name = null, $ignore_request = false) {

        if (!isset($name)) {
            if (isset($this->defaultModel)) {
                $name = $this->defaultModel;
            } else {
                throw new \RuntimeException("Unable to find a model", 500);
            }
        }

        $name = ucfirst($name);

        return Model::getInstance($name, $ignore_request);

    }

    /**
     * Méthode pour renvoyer le document HTML associé à l'application.
     *
     * @return Document Le document HTML.
     *
     * @note Juste un proxy pour Web::getDocument()
     */
    protected function getDocument() {

        return Web::getInstance()
                  ->getDocument();
    }

    /**
     * Méthode pour récupérer le nom de la vue.
     *
     * @return  string  Le nom de la vue.
     *
     * @throws  \RuntimeException
     */
    public function getName() {

        if (empty($this->name)) {
            $r         = null;
            $classname = join('', array_slice(explode('\\', get_class($this)), -1));
            if (!preg_match('/(.*)View/i', $classname, $r)) {
                throw new \RuntimeException('Unable to detect view name', 500);
            }
            $this->name = $r[1];
        }

        return $this->name;
    }

    /**
     * Méthode appelée avant la création du rendu.
     * On peut l'utiliser pour récupérer des données depuis le modèle
     * et les affecter à la vue.
     */
    protected function beforeRender() {

    }

    /**
     * Méthode pour effectuer le rendu de la vue.
     *
     * @return  string  La vue rendue.
     *
     * @throws  \RuntimeException
     */
    public function render() {

        $this->beforeRender();

        // On inclut la feuille de style si elle existe.
        $path = $this->getPath($this->stylesheet, 'css');
        if ($path !== false) {
            $app = Web::getInstance();
            $doc = $this->getDocument();
            $uri = str_replace(JPATH_BASE . "/", $app->get('uri.base.path'), $path);
            $doc->addStylesheet($uri);
        }

        return parent::render();
    }
}
