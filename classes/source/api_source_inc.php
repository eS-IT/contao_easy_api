<?php
/**
 * @author      pfroch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2013
 * @license     LGPL
 * @package     easy-api
 * @filesource  api_source.php
 * @version     1.0.0
 * @since       18.09.13 - 14:29
 */

namespace esit\easy_api;


abstract class api_source extends \Controller{

    abstract public function load();
    abstract public function create();
    abstract public function delete();
    abstract public function update();

}