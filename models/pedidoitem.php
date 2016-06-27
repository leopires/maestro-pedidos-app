<?php

namespace pedidos\models;

class Pedidoitem extends map\PedidoitemMap {

    public static function config() {
        return array(
            'log' => array(),
            'validators' => array(
                'idProduto' => array('notnull', 'notblank'),
                'idPedido' => array('notnull', 'notblank'),
                'quantidade' => array('notnull', 'notblank'),
            ),
            'fieldDescription' => array(
                'idProduto' => 'Produto ',
                'idPedido' => 'ID do Pedido ',
                'quantidade' => 'Quantidade '
            )
        );
    }

    public function listByIdPedido($idPedido) {
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