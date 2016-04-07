<?php
/**
 * @category   Maestro
 * @package    UFJF
 * @subpackage 
 * @copyright  Copyright (c) 2003-2012 UFJF (http://www.ufjf.br)
 * @license    http://siga.ufjf.br/license
 * @version    
 * @since      
 */

// wizard - code section created by Wizard Module - 03/04/2016 22:49:48

return array(
    'pedidos' => array('Pedidos', 'pedidos/main/main', 'pedidosIconForm', '', A_ACCESS, array(
        'cliente' => array('Cliente', 'pedidos/cliente/formFind', 'iconCliente', '', A_ACCESS, array()),
        'produto' => array('Produto', 'pedidos/produto/main', 'iconProduto', '', A_ACCESS, array()),
        'pedido' => array('Pedido', 'pedidos/pedido/main', 'iconPedido', '', A_ACCESS, array()),
        'vendedor' => array('Vendedor', 'pedidos/vendedor/main', 'iconVendedor', '', A_ACCESS, array()),
        //'pedidoitem' => array('Pedidoitem', 'pedidos/pedidoitem/main', 'pedidosIconForm', '', A_ACCESS, array()),
    ))

);

// end - wizard

?>