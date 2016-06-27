<?php

use pedidos\models\Pedido as Pedido;

class formFind extends MForm {

    public function __construct() {
        parent::__construct();
    }

    public function createFields() {
        $this->setFieldsFromXML("formFind.xml");
        $this->setBase("../formBase");
        $this->setTitle("Pedidos Realizados");
    }

    public function formataDadosPedidos($currentRow, $rowData, $actions, $columns, $query, $grid) {
        
        $columns["idPedido"]->control[$currentRow]->setText(Pedido::formataNumeroPedido($rowData[0]));
        $columns["situacao"]->control[$currentRow]->setValue(Pedido::getSituacoes()[$rowData[4]]);
    }
    
}
