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

class PedidoitemMap extends \MBusinessModel {

    
    public static function ORMMap() {

        return array(
            'class' => \get_called_class(),
            'database' => 'db_pedidos',
            'table' => 'PEDIDOITEM',
            'attributes' => array(
                'idPedidoItem' => array('column' => 'idPedidoItem','key' => 'primary','idgenerator' => 'seq_PEDIDOITEM','type' => 'long'),
                'quantidade' => array('column' => 'quantidade','type' => 'integer'),
                'idPedido' => array('column' => 'idPedido','key' => 'foreign','type' => 'long'),
                'idProduto' => array('column' => 'idProduto','key' => 'foreign','type' => 'long'),
            ),
            'associations' => array(
                'pedido' => array('toClass' => 'pedidos\models\pedido', 'cardinality' => 'oneToOne' , 'keys' => 'idPedido:idPedido'), 
                'produto' => array('toClass' => 'pedidos\models\produto', 'cardinality' => 'oneToOne' , 'keys' => 'idProduto:idProduto'), 
            )
        );
    }
    
    /**
     * 
     * @var long 
     */
    protected $idPedidoItem;
    /**
     * 
     * @var integer 
     */
    protected $quantidade;
    /**
     * 
     * @var long 
     */
    protected $idPedido;
    /**
     * 
     * @var long 
     */
    protected $idProduto;

    /**
     * Associations
     */
    protected $pedido;
    protected $produto;
    

    /**
     * Getters/Setters
     */
    public function getIdPedidoItem() {
        return $this->idPedidoItem;
    }

    public function setIdPedidoItem($value) {
        $this->idPedidoItem = $value;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($value) {
        $this->quantidade = $value;
    }

    public function getIdPedido() {
        return $this->idPedido;
    }

    public function setIdPedido($value) {
        $this->idPedido = $value;
    }

    public function getIdProduto() {
        return $this->idProduto;
    }

    public function setIdProduto($value) {
        $this->idProduto = $value;
    }
    /**
     *
     * @return Association
     */
    public function getPedido() {
        if (is_null($this->pedido)){
            $this->retrieveAssociation("pedido");
        }
        return  $this->pedido;
    }
    /**
     *
     * @param Association $value
     */
    public function setPedido($value) {
        $this->pedido = $value;
    }
    /**
     *
     * @return Association
     */
    public function getAssociationPedido() {
        $this->retrieveAssociation("pedido");
    }
    /**
     *
     * @return Association
     */
    public function getProduto() {
        if (is_null($this->produto)){
            $this->retrieveAssociation("produto");
        }
        return  $this->produto;
    }
    /**
     *
     * @param Association $value
     */
    public function setProduto($value) {
        $this->produto = $value;
    }
    /**
     *
     * @return Association
     */
    public function getAssociationProduto() {
        $this->retrieveAssociation("produto");
    }

    

}
// end - wizard

?>