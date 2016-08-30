function setupLookupCliente() {
    
    limpaDadosClienteSelecionado();
    
    lookupNomeCliente.setContext({
        name: 'lookupNomeCliente',
        action: '/~leonardo/maestro/index.php/pedidos/pedido/lookupClientesByVendedor/' + getidVendedorSelecionado(),
        related: 'pedido::idCliente:idCliente,nomeCliente:nome',
        filter: '',
        form: 'formNew',
        field: 'nomeCliente',
        autocomplete: ''
    });
}

function getidVendedorSelecionado() {
    return document.getElementById("pedido::idVendedor").value;
}

function limpaDadosClienteSelecionado() {
    document.getElementById("pedido::idCliente").value = "";
    document.getElementById("nomeCliente").value = "";
}


