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

class Cliente extends map\ClienteMap {

    public static function config() {
        return array(
            'log' => array(),
            'validators' => array(
                'nome' => array('notnull', 'notblank'),
                'email' => array('notnull', 'notblank'),
                'telefone' => array('notnull', 'notblank'),
                'dataCadastro' => array('notnull', 'notblank'),
                'dataUltimaAtualizacao' => array('notnull', 'notblank'),
            ),
            'converters' => array()
        );
    }

    public function getDescription() {
        return $this->getNome();
    }

    public function listByFilter($filter) {
        /**
          $criteria = $this->getCriteria()->select('*')->orderBy('idCliente');
          if ($filter->nome) {
          $criteria->where("nome LIKE '{$filter->nome}%'");
          }
          return $criteria;
         */
        
        throw new \RuntimeException("Ocorreu um erro ao fazer a pesquisa.");
    
    }

    public function save() {
        if (!$this->isPersistent()) {
            $this->setDataCadastro(\Manager::getSysTime());
        }
        $this->setDataUltimaAtualizacao(\Manager::getSysTime());
        parent::save();
    }

}

?>