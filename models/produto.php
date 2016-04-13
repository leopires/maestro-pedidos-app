<?php

namespace pedidos\models;

class Produto extends map\ProdutoMap {

    public static function config() {
        return array(
            'log' => array(),
            'validators' => array(
            ),
            'converters' => array()
        );
    }

    public static function listStatusProduto() {
        return array(1 => "Ativo", 0 => "Inativo");
    }

    public function getDescription() {
        return $this->getNome();
    }

}

?>