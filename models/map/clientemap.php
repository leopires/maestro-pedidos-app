<?php
/**
 * @category   Maestro
 * @package    UFJF
 * @subpackage pedidos
 * @copyright  Copyright (c) 2003-2013 UFJF (http://www.ufjf.br)
 * @license    http://siga.ufjf.br/license
 * @version
 * @since
 */

// wizard - code section created by Wizard Module

namespace pedidos\models\map;

class ClienteMap extends \MBusinessModel {

    
    public static function ORMMap() {

        return array(
            'class' => \get_called_class(),
            'database' => 'db_pedidos',
            'table' => 'CLIENTE',
            'attributes' => array(
                'idCliente' => array('column' => 'idCliente','key' => 'primary','idgenerator' => 'identity','type' => 'long'),
                'nome' => array('column' => 'nome','type' => 'string'),
                'email' => array('column' => 'email','type' => 'string'),
                'telefone' => array('column' => 'telefone','type' => 'string'),
                'dataCadastro' => array('column' => 'dataCadastro','type' => 'timestamp'),
                'dataUltimaAtualizacao' => array('column' => 'DataUltimaAtualizacao','type' => 'timestamp'),
            ),
            'associations' => array(
                'historicoPedidos' => array('toClass' => 'pedidos\models\pedido', 'cardinality' => 'oneToMany' , 'keys' => 'idCliente:idCliente'), 
                'vendedores' => array('toClass' => 'pedidos\models\vendedor', 'cardinality' => 'manyToMany' , 'associative' => 'CLIENTE_VENDEDOR'), 
            )
        );
    }
    
    /**
     * 
     * @var long 
     */
    protected $idCliente;
    /**
     * 
     * @var string 
     */
    protected $nome;
    /**
     * 
     * @var string 
     */
    protected $email;
    /**
     * 
     * @var string 
     */
    protected $telefone;
    /**
     * 
     * @var date 
     */
    protected $dataCadastro;
    /**
     * 
     * @var date 
     */
    protected $dataUltimaAtualizacao;

    /**
     * Associations
     */
    protected $historicoPedidos;
    protected $vendedores;
    

    /**
     * Getters/Setters
     */
    public function getIdCliente() {
        return $this->idCliente;
    }

    public function setIdCliente($value) {
        $this->idCliente = $value;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($value) {
        $this->nome = $value;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($value) {
        $this->email = $value;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($value) {
        $this->telefone = $value;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    public function setDataCadastro($value) {
        if (!($value instanceof \MTimestamp)) {
            $value = new \MTimestamp($value);
        }
        $this->dataCadastro = $value;
    }

    public function getDataUltimaAtualizacao() {
        return $this->dataUltimaAtualizacao;
    }

    public function setDataUltimaAtualizacao($value) {
        if (!($value instanceof \MTimestamp)) {
            $value = new \MTimestamp($value);
        }
        $this->dataUltimaAtualizacao = $value;
    }
    /**
     *
     * @return Association
     */
    public function getHistoricoPedidos() {
        if (is_null($this->historicoPedidos)){
            $this->retrieveAssociation("historicoPedidos");
        }
        return  $this->historicoPedidos;
    }
    /**
     *
     * @param Association $value
     */
    public function setHistoricoPedidos($value) {
        $this->historicoPedidos = $value;
    }
    /**
     *
     * @return Association
     */
    public function getAssociationHistoricoPedidos() {
        $this->retrieveAssociation("historicoPedidos");
    }
    /**
     *
     * @return Association
     */
    public function getVendedores() {
        if (is_null($this->vendedores)){
            $this->retrieveAssociation("vendedores");
        }
        return  $this->vendedores;
    }
    /**
     *
     * @param Association $value
     */
    public function setVendedores($value) {
        $this->vendedores = $value;
    }
    /**
     *
     * @return Association
     */
    public function getAssociationVendedores() {
        $this->retrieveAssociation("vendedores");
    }

    

}
// end - wizard

?>