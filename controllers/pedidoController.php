<?php

Manager::import("pedidos\models\*");

use pedidos\models\Pedido as Pedido;

class PedidoController extends MController {

    public function main() {
        $this->render("formBase");
    }

    public function formFind() {

        $resultQuery = null;
        $pedido = new Pedido();

        if ($this->data->numeroPedido) {
            $resultQuery = $pedido->listByNumeroPedido($this->data->numeroPedido);
        } else if (($this->data->dataInicio) || ($this->data->dataFim)) {
            $resultQuery = $pedido->listEntreDatas($this->data->dataInicio, $this->data->dataFim);
        } else {
            $resultQuery = $pedido->listAll();
        }

        $this->data->query = $resultQuery;
        $this->render();
    }

    public function formNew() {
        $this->data->action = '@pedidos/pedido/save';
        $this->render();
    }

    public function formObject() {
        $this->data->pedido = Pedido::create($this->data->id)->getData();
        $this->render();
    }

    public function formUpdate() {
        $pedido = new Pedido($this->data->id);
        $this->data->pedido = $pedido->getData();
        $this->data->pedido->idVendedorDesc = $pedido->getVendedor()->getDescription();

        $this->data->action = '@pedidos/pedido/save/' . $this->data->id;
        $this->render();
    }

    public function formDelete() {
        $pedido = new Pedido($this->data->id);
        $ok = '>pedidos/pedido/delete/' . $pedido->getId();
        $cancelar = '>pedidos/pedido/formObject/' . $pedido->getId();
        $this->renderPrompt('confirmation', "Confirma remoção do Pedido [{pedido->getDescription()}] ?", $ok, $cancelar);
    }

    public function formItensPedido() {
        $this->data->emitirPedido = "@pedidos/pedido/emitirPedido";
        try {
            $pedido = $this->recuperaPedido();
            $this->data->pedido->idPedido = $pedido->getIdPedido();
            $this->data->pedido->nomeCliente = $pedido->getCliente()->getNome();
            $this->data->pedido->nomeVendedor = $pedido->getVendedor()->getNome();
            $this->data->pedido->dataPedido = $pedido->getDataCriacao()->format();
            $this->data->listaProdutos = $this->getListaProdutos();
            $this->data->itensPedido = $pedido->listItensPedido()->asQuery();
            $currencyFormatter = new MCurrencyFormatter();
            $this->data->valorTotalPedido = $currencyFormatter->formatWithSymbol($pedido->calculaValorTotalPedido());
            $this->render();
        } catch (EControllerException $ex) {
            $go = ">pedidos/pedido/formFind";
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, $ex->getMessage(), $go);
        } catch (Exception $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, $ex->getMessage());
        }
    }

    public function emitirPedido() {
        try {
            $pedido = new Pedido($this->data->idPedido);
            $pedido->trocaSituacaoPedidoParaEmitido();
            $goSucess = ">pedidos/pedido/formFind";
            $this->renderPrompt(MPrompt::MSG_TYPE_INFORMATION, "Pedido Nº {$pedido->getNumeroPedidoFormatado()} emitido com sucesso!", $goSucess);
        } catch (Exception $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, $ex->getMessage());
        }
    }

    private function recuperaPedido() {
        try {

            if (empty($this->data->id)) {
                throw new EControllerException("ID do pedido indefinida.");
            }

            $idPedido = $this->data->id;
            $pedido = new Pedido($idPedido);

            if (!$pedido->isPersistent()) {
                throw new EControllerException("Nenhum pedido encontrado com o ID: {$idPedido}");
            }

            return $pedido;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    private function getListaProdutos() {
        try {
            $produto = new pedidos\models\Produto();
            return $produto->listAllProdutosAtivos()->asQuery()->chunkResult();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function addItemPedido() {
        try {
            $itemPedido = new pedidos\models\Pedidoitem();
            $itemPedido->setIdPedido($this->data->idPedido);
            $itemPedido->setIdProduto($this->data->produto);
            $itemPedido->setQuantidade($this->data->quantidade);
            $itemPedido->save();
            $goSucess = ">pedidos/pedido/formItensPedido/" . $this->data->idPedido;
            $this->renderPrompt(MPrompt::MSG_TYPE_INFORMATION, "Item incluído com sucesso no pedido.", $goSucess);
        } catch (Exception $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, $ex->getMessage());
        }
    }

    public function lookupClientesByVendedor() {
        try {
            if (!$this->data->id) {
                throw new Exception("Por favor, selecione o Vendedor.");
            }

            $cliente = new \pedidos\models\Cliente();
            $idVendedor = $this->data->id;
            $nomeCliente = $this->data->nomeCliente;
            $this->data->query = $cliente->listByVendedorAndNome($idVendedor, $nomeCliente);
            $this->render("cliente/lookup");
        } catch (Exception $ex) {
            $go = ">pedidos/pedido/reloadMe";
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, $ex->getMessage(), $go);
        }
    }

    public function reloadMe() {
        $this->redirect("formNew");
    }

    public function lookup() {
        $model = new Pedido();
        $filter->idPedido = $this->data->idPedido;
        $this->data->query = $model->listByFilter($filter)->asQuery();
        $this->render();
    }

    public function save() {
        try {
            $pedido = new Pedido($this->data->id);
            $pedido->setIdVendedor($this->data->pedido->idVendedor);
            $pedido->setIdCliente($this->data->pedido->idCliente);
            $pedido->setSituacao(Pedido::$PEDIDO_SITUACAO_NOVO);
            $pedido->save();
            $nextStepItensPedido = '>pedidos/pedido/formItensPedido/' . $pedido->getIdPedido();
            $this->renderPrompt(MPrompt::MSG_TYPE_INFORMATION, "Pedido {$pedido->getIdPedido()} criado com sucesso. Na tela seguinte, você deverá informar os itens deste pedido.", $nextStepItensPedido);
        } catch (Exception $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, $ex->getMessage());
        }
    }

    public function delete() {
        $pedido = new Pedido($this->data->id);
        $pedido->delete();
        $go = '>pedidos/pedido/formFind';
        $this->renderPrompt('information', "Pedido [{$this->data->idPedido}] removido.", $go);
    }

}
