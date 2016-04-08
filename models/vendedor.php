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

require_once 'exceptions/ModelException.php';

use pedidos\exceptions\ModelException as ModelException;

class Vendedor extends map\VendedorMap {

    public static function config() {
        return array(
            'log' => array(),
            'validators' => array(
                'nome' => array('notnull', 'notblank'),
                'cpf' => array('notnull', 'notblank'),
                'email' => array('notnull', 'notblank'),
                'dataCadastro' => array('notnull', 'notblank'),
                'dataUltimaAtualizacao' => array('notnull', 'notblank'),
            ),
            'converters' => array()
        );
    }

    private function getBasicCriteria() {
        return $this->getCriteria()->select('*');
    }

    public function getDescription() {
        return $this->getNome();
    }

    /**
     * Faz uma pesquina nos Vendedor pelo nome.
     * @param String $nome Nome ou parte do nome a ser pesquisado.
     * @return Criteria Pesquisa a ser executada.
     */
    public function listByNome($nome) {
        $nomeCliente = filter_var($nome, FILTER_SANITIZE_MAGIC_QUOTES);
        return $this->getBasicCriteria()->where("nome LIKE '%{$nomeCliente}%'");
    }

    public function save() {
        try {
            
            $this->setCpf(str_replace("-", "", str_replace(".", "", $this->getCpf())));
            
            if (!$this->isPersistent()) {
                $this->setDataCadastro(\Manager::getSysTime());
            }
            $this->setDataUltimaAtualizacao(\Manager::getSysTime());
            parent::save();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

}

?>