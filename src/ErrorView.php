<?php
/**
 * Part of the ETD Framework View Package
 *
 * @copyright   Copyright (C) 2015 ETD Solutions, SARL Etudoo. Tous droits réservés.
 * @license     Apache License 2.0; see LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

namespace EtdSolutions\View;

defined('_JEXEC') or die;

class ErrorView extends HtmlView {

    protected $error;

    public function beforeRender() {

        $this->error = $this->model->getError();
    }

}
