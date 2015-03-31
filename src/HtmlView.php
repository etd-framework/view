<?php
/**
 * Part of the ETD Framework View Package
 *
 * @copyright   Copyright (C) 2015 ETD Solutions, SARL Etudoo. Tous droits réservés.
 * @license     Apache License 2.0; see LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

namespace EtdSolutions\View;

use EtdSolutions\Model\Model;
use Joomla\Renderer\RendererInterface;
use Joomla\View\BaseHtmlView;



/**
 * Vue HTML
 */
class HtmlView extends BaseHtmlView {

    /**
     * @var $name string Le nom de la vue.
     */
    protected $name;

    /**
     * @var $defaultModel string Le nom du model par défaut.
     */
    protected $defaultModel;

    /**
     * Method to instantiate the view.
     *
     * @param   Model              $model     The model object.
     * @param   RendererInterface  $renderer  The renderer object.
     *
     * @since   __DEPLOY_VERSION__
     */
    public function __construct(Model $model = null, RendererInterface $renderer = null) {

        $this->defaultModel = $this->getName();

        $model    = isset($model) ? $model : $this->getModel();

        parent::__construct($model, $renderer);
    }

    /**
     * Méthode pour charger un model.
     *
     * @param string $name           Le nom du modèle. Facultatif.
     * @param   bool $ignore_request Utilisé pour ignorer la mise à jour de l'état depuis l'input.
     *
     * @return Model Le modèle.
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
}
