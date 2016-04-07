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

class ProdutoMap extends \MBusinessModel {

    
    public static function ORMMap() {

        return array(
            'class' => \get_called_class(),
            'database' => 'db_pedidos',
            'table' => 'PRODUTO',
            'attributes' => array(
                'idProduto' => array('column' => 'idProduto','key' => 'primary','idgenerator' => 'seq_PRODUTO','type' => 'long'),
                'nome' => array('column' => 'nome','type' => 'string'),
                'descricao' => array('column' => 'descricao','type' => 'string'),
                'codigoEAN' => array('column' => 'codigoEAN','type' => 'string'),
                'precoUnitario' => array('column' => 'precoUnitario','type' => 'double'),
                'ativo' => array('column' => 'ativo','type' => 'byte'),
                'dataCadastro' => array('column' => 'dataCadastro','type' => 'date'),
                'dataUltimaAtualizacao' => array('column' => 'dataUltimaAtualizacao','type' => 'date'),
            ),
            'associations' => array(
                'historicoVenda' => array('toClass' => 'pedidos\models\pedidoitem', 'cardinality' => 'oneToMany' , 'keys' => 'idProduto:idProduto'), 
            )
        );
    }
    
    /**
     * 
     * @var long 
     */
    protected $idProduto;
    /**
     * 
     * @var string 
     */
    protected $nome;
    /**
     * 
     * @var string 
     */
    protected $descricao;
    /**
     * 
     * @var string 
     */
    protected $codigoEAN;
    /**
     * 
     * @var double 
     */
    protected $precoUnitario;
    /**
     * 
     * @var byte 
     */
    protected $ativo;
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
    protected $historicoVenda;
    

    /**
     * Getters/Setters
     */
    public function getIdProduto() {
        return $this->idProduto;
    }

    public function setIdProduto($value) {
        $this->idProduto = $value;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($value) {
        $this->nome = $value;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($value) {
        $this->descricao = $value;
    }

    public function getCodigoEAN() {
        return $this->codigoEAN;
    }

    public function setCodigoEAN($value) {
        $this->codigoEAN = $value;
    }

    public function getPrecoUnitario() {
        return $this->precoUnitario;
    }

    public function setPrecoUnitario($value) {
        $this->precoUnitario = $value;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function setAtivo($value) {
        $this->ativo = $value;
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
    public function getHistoricoVenda() {
        if (is_null($this->historicoVenda)){
            $this->retrieveAssociation("historicoVenda");
        }
        return  $this->historicoVenda;
    }
    /**
     *
     * @param Association $value
     */
    public function setHistoricoVenda($value) {
        $this->historicoVenda = $value;
    }
    /**
     *
     * @return Association
     */
    public function getAssociationHistoricoVenda() {
        $this->retrieveAssociation("historicoVenda");
    }

    

}
// end - wizard

?>