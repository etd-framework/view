<?php
/**
 * Part of the ETD Framework View Package
 *
 * @copyright   Copyright (C) 2015 ETD Solutions, SARL Etudoo. Tous droits réservés.
 * @license     Apache License 2.0; see LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

namespace EtdSolutions\View;

use Joomla\DI\ContainerAwareInterface;
use Joomla\DI\ContainerAwareTrait;
use Joomla\View\BaseHtmlView;

/**
 * Vue HTML
 */
class HtmlView extends BaseHtmlView implements ContainerAwareInterface {

    use ContainerAwareTrait;

}
