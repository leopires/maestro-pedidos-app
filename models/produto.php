<?php
/**
 * 
 *
 * @category   Maestro
 * @package    UFJF
 * @subpackage pedidos
 * @copyright  Copyright (c) 2003-2012 UFJF (http://www.ufjf.br)
 * @license    http://siga.ufjf.br/license
 * @version    
 * @since      
 */

namespace pedidos\models;

class Produto extends map\ProdutoMap {

    public static function config() {
        return array(
            'log' => array(  ),
            'validators' => array(
            ),
            'converters' => array()
        );
    }
    
    public function getDescription(){
        return $this->getIdProduto();
    }

    public function listByFilter($filter){
        $criteria = $this->getCriteria()->select('*')->orderBy('idProduto');
        if ($filter->idProduto){
            $criteria->where("idProduto LIKE '{$filter->idProduto}%'");
        }
        return $criteria;
    }
}

?>