<?php

namespace pedidos\models;

class Pedido extends map\PedidoMap {

    public static $SITUACAO_NOVO = 1;
    public static $SITUACAO_FATURADO = 2;
    public static $SITUACAO_CANCELADO = 3;

    public static function config() {
        return array(
            'log' => array(),
            'validators' => array(
            ),
            'converters' => array()
        );
    }

    public function getDescription() {
        return $this->getIdPedido();
    }

    public function save() {
        try {
            if (!$this->isPersistent()) {
                $this->setDataCriacao(\Manager::getSysTime());
            }
            $this->setDataUltimaAtualizacao(\Manager::getSysTime());
            parent::save();
        } catch (Exception $ex) {
            throw new \EModelException($ex->getMessage());
        }
    }

    public function listByFilter($filter) {
        $criteria = $this->getCriteria()->select('*')->orderBy('idPedido');
        if ($filter->idPedido) {
            $criteria->where("idPedido LIKE '{$filter->idPedido}%'");
        }
        return $criteria;
    }

    /**
     * Dado um determinado Vendedor, recupera o número de pedidos dele.
     * @param Integer $idVendedor Identificador do Vendedor.
     * @return Integer Número de pedidos do Vendedor.
     * @throws \EModelException Caso algum erro ocorra durante a contagem dos pedidos.
     */
    public function getTotalPedidosByIdVendedor($idVendedor) {
        try {
            $criteria = $this->getCriteria()->select("count(idPedido)")->where("vendedor.idVendedor = " . "{$idVendedor}");
            return $criteria->asQuery()->getResult()[0][0];
        } catch (Exception $ex) {
            throw new \EModelException("Ocorreu um erro ao recuperar o total de pedidos do Vendedor.");
        }
    }

}

?>