<?php

Manager::import("pedidos\models\*");

use pedidos\models\Pedido as Pedido;

class PedidoController extends MController {

    public function main() {
        $this->render("formBase");
    }

    public function formFind() {
        $filter = new stdClass();
        $pedido = new Pedido($this->data->id);
        $filter->idPedido = $this->data->idPedido;
        $this->data->query = $pedido->listByFilter($filter)->asQuery();
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

    public function lookupClientesByVendedor() {
        try {
            
            if(!$this->data->id) {
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
            $pedido->setSituacao(Pedido::$SITUACAO_NOVO);
            $pedido->save();
            $go = '>pedidos/pedido/formObject/' . $pedido->getId();
            $this->renderPrompt(MPrompt::MSG_TYPE_INFORMATION, "Pedido {$pedido->getIdPedido()} criado com sucesso.", $go);
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
