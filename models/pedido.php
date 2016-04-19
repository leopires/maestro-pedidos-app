<?php

namespace pedidos\models;

class Pedido extends map\PedidoMap {

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

    public function listByFilter($filter) {
        $criteria = $this->getCriteria()->select('*')->orderBy('idPedido');
        if ($filter->idPedido) {
            $criteria->where("idPedido LIKE '{$filter->idPedido}%'");
        }
        return $criteria;
    }

    public function getTotalPedidosByIdVendedor($idVendedor) {
        try {
            $criteria = $this->getCriteria()->select("count(idPedido)")->where("vendedor.idVendedor = " . "{$idVendedor}");
            return $criteria->asQuery()->getResult()[0][0];
        } catch (Exception $ex) {
            throw new ModelException("Ocorreu um erro ao recuperar o total de pedidos do Vendedor.");
        }
    }

}

?>