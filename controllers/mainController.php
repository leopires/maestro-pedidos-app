<?php
/**
 * 
 *
 * @category   Maestro
 * @package    UFJF
 * @subpackage 
 * @copyright  Copyright (c) 2003-2012 UFJF (http://www.ufjf.br)
 * @license    http://siga.ufjf.br/license
 * @version    
 * @since      
 */
class MainController extends \MController {

    public function init(){
        Manager::checkLogin();
    }

    public function main() {
        $this->render();
    }
}

?>