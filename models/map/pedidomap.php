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

class PedidoMap extends \MBusinessModel {

    
    public static function ORMMap() {

        return array(
            'class' => \get_called_class(),
            'database' => 'db_pedidos',
            'table' => 'PEDIDO',
            'attributes' => array(
                'idPedido' => array('column' => 'idPedido','key' => 'primary','idgenerator' => 'seq_PEDIDO','type' => 'long'),
                'situacao' => array('column' => 'situacao','type' => 'byte'),
                'dataCriacao' => array('column' => 'dataCriacao','type' => 'date'),
                'dataUltimaAtualizacao' => array('column' => 'dataUltimaAlteracao','type' => 'date'),
                'idCliente' => array('column' => 'idCliente','key' => 'foreign','type' => 'long'),
                'idVendedor' => array('column' => 'idVendedor','key' => 'foreign','type' => 'integer'),
            ),
            'associations' => array(
                'cliente' => array('toClass' => 'pedidos\models\cliente', 'cardinality' => 'oneToOne' , 'keys' => 'idCliente:idCliente'), 
                'vendedor' => array('toClass' => 'pedidos\models\vendedor', 'cardinality' => 'oneToOne' , 'keys' => 'idVendedor:idVendedor'), 
                'itensPedido' => array('toClass' => 'pedidos\models\pedidoitem', 'cardinality' => 'oneToMany' , 'keys' => 'idPedido:idPedido'), 
            )
        );
    }
    
    /**
     * 
     * @var long 
     */
    protected $idPedido;
    /**
     * 
     * @var byte 
     */
    protected $situacao;
    /**
     * 
     * @var date 
     */
    protected $dataCriacao;
    /**
     * 
     * @var date 
     */
    protected $dataUltimaAtualizacao;
    /**
     * 
     * @var long 
     */
    protected $idCliente;
    /**
     * 
     * @var integer 
     */
    protected $idVendedor;

    /**
     * Associations
     */
    protected $cliente;
    protected $vendedor;
    protected $itensPedido;
    

    /**
     * Getters/Setters
     */
    public function getIdPedido() {
        return $this->idPedido;
    }

    public function setIdPedido($value) {
        $this->idPedido = $value;
    }

    public function getSituacao() {
        return $this->situacao;
    }

    public function setSituacao($value) {
        $this->situacao = $value;
    }

    public function getDataCriacao() {
        return $this->dataCriacao;
    }

    public function setDataCriacao($value) {
        if (!($value instanceof \MDate)) {
            $value = new \MDate($value);
        }
        $this->dataCriacao = $value;
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

    public function getIdCliente() {
        return $this->idCliente;
    }

    public function setIdCliente($value) {
        $this->idCliente = $value;
    }

    public function getIdVendedor() {
        return $this->idVendedor;
    }

    public function setIdVendedor($value) {
        $this->idVendedor = $value;
    }
    /**
     *
     * @return Association
     */
    public function getCliente() {
        if (is_null($this->cliente)){
            $this->retrieveAssociation("cliente");
        }
        return  $this->cliente;
    }
    /**
     *
     * @param Association $value
     */
    public function setCliente($value) {
        $this->cliente = $value;
    }
    /**
     *
     * @return Association
     */
    public function getAssociationCliente() {
        $this->retrieveAssociation("cliente");
    }
    /**
     *
     * @return Association
     */
    public function getVendedor() {
        if (is_null($this->vendedor)){
            $this->retrieveAssociation("vendedor");
        }
        return  $this->vendedor;
    }
    /**
     *
     * @param Association $value
     */
    public function setVendedor($value) {
        $this->vendedor = $value;
    }
    /**
     *
     * @return Association
     */
    public function getAssociationVendedor() {
        $this->retrieveAssociation("vendedor");
    }
    /**
     *
     * @return Association
     */
    public function getItensPedido() {
        if (is_null($this->itensPedido)){
            $this->retrieveAssociation("itensPedido");
        }
        return  $this->itensPedido;
    }
    /**
     *
     * @param Association $value
     */
    public function setItensPedido($value) {
        $this->itensPedido = $value;
    }
    /**
     *
     * @return Association
     */
    public function getAssociationItensPedido() {
        $this->retrieveAssociation("itensPedido");
    }

    

}
// end - wizard

?>