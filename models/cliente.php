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

    private function getBasicCriteria() {
        $criteria = $this->getCriteria()->select('*');
        return $criteria;
    }

    /**
     * Faz uma pesquina nos Clientes pelo nome.
     * @param String $nome Nome ou parte do nome a ser pesquisado.
     * @return Criteria Pesquisa a ser executada.
     */
    public function listByNome($nome) {
        $nomeCliente = filter_var($nome, FILTER_SANITIZE_MAGIC_QUOTES);
        return $this->getBasicCriteria()->where("nome LIKE '%{$nomeCliente}%'");
    }
    
    public function listByVendedor($idVendedor) {
        try {
            return $this->getBasicCriteria()->where("vendedores.idVendedor = " . "{$idVendedor}");
        } catch (Exception $ex) {
            throw new ModelException("Ocorreu um erro ao recuperar os Clientes do Vendedor.");
        }
    }
    
    public function save() {

        try {
            if (!$this->isPersistent()) {
                $this->setDataCadastro(\Manager::getSysTime());
            }
            $this->setDataUltimaAtualizacao(\Manager::getSysTime());
            parent::save();
        } catch (\Exception $ex) {
                        
            if (((strpos($ex->getMessage(), "23000") !== false)) && (strpos($ex->getMessage(), "email"))) {
                throw new ModelException("O e-mail informado já está cadastrado para outra pessoa.");
            } else {
                throw new \Exception("Ocorreu um erro ao salvar os dados do Cliente.");
            }
        }
    }

}

?>