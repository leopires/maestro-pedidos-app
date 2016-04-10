<?php

class formFind extends MForm {

    public function __construct() {
        parent::__construct();
    }

    public function createFields() {
        $this->setFieldsFromXML("formFind.xml");
        $this->setBase("../formBase");
        $this->setTitle("Pesquisa de vendedores");
    }

    public function loadClientesAndPedidos($currentRow, $rowData, $actions, $columns, $query, $grid) {
        $vendedor = new pedidos\models\Vendedor();

        $totalClientes = str_pad($vendedor->getTotalClientesByIdVendedor($rowData[0]), 2, "0", STR_PAD_LEFT);
        $columns["totalClientes"]->control[$currentRow]->setValue($totalClientes);
        
        $totalPedidos = str_pad($vendedor->getTotalPedidos($rowData[0]), 2, "0", STR_PAD_LEFT);      
        $columns["totalPedidos"]->control[$currentRow]->setValue($totalPedidos);
    }    
}
