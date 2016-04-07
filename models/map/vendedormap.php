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

class VendedorMap extends \MBusinessModel {

    
    public static function ORMMap() {

        return array(
            'class' => \get_called_class(),
            'database' => 'db_pedidos',
            'table' => 'VENDEDOR',
            'attributes' => array(
                'idVendedor' => array('column' => 'idVendedor','key' => 'primary','idgenerator' => 'seq_VENDEDOR','type' => 'integer'),
                'nome' => array('column' => 'nome','type' => 'string'),
                'cpf' => array('column' => 'cpf','type' => 'string'),
                'email' => array('column' => 'email','type' => 'string'),
                'dataCadastro' => array('column' => 'dataCadastro','type' => 'date'),
                'dataUltimaAtualizacao' => array('column' => 'dataUltimaAtualizacao','type' => 'date'),
            ),
            'associations' => array(
                'carteiraClientes' => array('toClass' => 'pedidos\models\cliente', 'cardinality' => 'manyToMany' , 'associative' => 'CLIENTE_VENDEDOR'), 
                'historicoPedidos' => array('toClass' => 'pedidos\models\pedido', 'cardinality' => 'oneToMany' , 'keys' => 'idVendedor:idVendedor'), 
            )
        );
    }
    
    /**
     * 
     * @var integer 
     */
    protected $idVendedor;
    /**
     * 
     * @var string 
     */
    protected $nome;
    /**
     * 
     * @var string 
     */
    protected $cpf;
    /**
     * 
     * @var string 
     */
    protected $email;
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
    protected $carteiraClientes;
    protected $historicoPedidos;
    

    /**
     * Getters/Setters
     */
    public function getIdVendedor() {
        return $this->idVendedor;
    }

    public function setIdVendedor($value) {
        $this->idVendedor = $value;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($value) {
        $this->nome = $value;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($value) {
        $this->cpf = $value;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($value) {
        $this->email = $value;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    public function setDataCadastro($value) {
        if (!($value instanceof \MDate)) {
            $value = new \MDate($value);
        }
        $this->dataCadastro = $value;
    }

    public function getDataUltimaAtualizacao() {
        return $this->dataUltimaAtualizacao;
    }

    public function setDataUltimaAtualizacao($value) {
        if (!($value instanceof \MDate)) {
            $value = new \MDate($value);
        }
        $this->dataUltimaAtualizacao = $value;
    }
    /**
     *
     * @return Association
     */
    public function getCarteiraClientes() {
        if (is_null($this->carteiraClientes)){
            $this->retrieveAssociation("carteiraClientes");
        }
        return  $this->carteiraClientes;
    }
    /**
     *
     * @param Association $value
     */
    public function setCarteiraClientes($value) {
        $this->carteiraClientes = $value;
    }
    /**
     *
     * @return Association
     */
    public function getAssociationCarteiraClientes() {
        $this->retrieveAssociation("carteiraClientes");
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

    

}
// end - wizard

?>