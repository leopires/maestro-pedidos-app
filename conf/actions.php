<?php

return array(
    'pedidos' => array('Pedidos', 'pedidos/main/main', 'pedidosIconForm', '', A_ACCESS, array(
        'cliente' => array('Cliente', 'pedidos/cliente/formFind', 'iconCliente', '', A_ACCESS, array()),
        'vendedor' => array('Vendedor', 'pedidos/vendedor/formFind', 'iconVendedor', '', A_ACCESS, array()),
        'produto' => array('Produto', 'pedidos/produto/formFind', 'iconProduto', '', A_ACCESS, array()),
        'pedido' => array('Pedido', 'pedidos/pedido/main', 'iconPedido', '', A_ACCESS, array()),
    ))

);

?>