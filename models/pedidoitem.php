<?php

namespace pedidos\models;

class Pedidoitem extends map\PedidoitemMap {

    public static function config() {
        return array(
            'log' => array(),
            'validators' => array(),
            'converters' => array()
        );
    }

    public function listPedidoItemByIdPedido($idPedido) {
        return $this->getCriteria()
                        ->select("idPedidoItem")
                        ->select("produto.nome")
                        ->select("produto.precoUnitario")
                        ->select("quantidade")
                        ->select("(produto.precoUnitario*quantidade) AS totalItem")
                        ->where("idPedido = {$idPedido}")->orderBy("produto.nome");
    }

}

?>