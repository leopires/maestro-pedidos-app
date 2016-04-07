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

class Pedidoitem extends map\PedidoitemMap {

    public static function config() {
        return array(
            'log' => array(  ),
            'validators' => array(
            ),
            'converters' => array()
        );
    }
    
    public function getDescription(){
        return $this->getIdPedidoItem();
    }

    public function listByFilter($filter){
        $criteria = $this->getCriteria()->select('*')->orderBy('idPedidoItem');
        if ($filter->idPedidoItem){
            $criteria->where("idPedidoItem LIKE '{$filter->idPedidoItem}%'");
        }
        return $criteria;
    }
}

?>