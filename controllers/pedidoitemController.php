<?php

Manager::import("pedidos\models\*");

class PedidoitemController extends MController {

    public function main() {
        $this->render("formBase");
    }

    public function formFind() {
        $pedidoitem= new Pedidoitem($this->data->id);
        $filter->idPedidoItem = $this->data->idPedidoItem;
        $this->data->query = $pedidoitem->listByFilter($filter)->asQuery();
        $this->render();
    }

    public function formNew() {
        $this->data->action = '@pedidos/pedidoitem/save';
        $this->render();
    }

    public function formObject() {
        $this->data->pedidoitem = Pedidoitem::create($this->data->id)->getData();
        $this->render();
    }

    public function formUpdate() {
        $pedidoitem= new Pedidoitem($this->data->id);
        $this->data->pedidoitem = $pedidoitem->getData();
        
        $this->data->action = '@pedidos/pedidoitem/save/' .  $this->data->id;
        $this->render();
    }

    public function formDelete() {
        $pedidoitem = new Pedidoitem($this->data->id);
        $ok = '>pedidos/pedidoitem/delete/' . $pedidoitem->getId();
        $cancelar = '>pedidos/pedidoitem/formObject/' . $pedidoitem->getId();
        $this->renderPrompt('confirmation', "Confirma remoção do Pedidoitem [{pedidoitem->getDescription()}] ?", $ok, $cancelar);
    }

    public function lookup() {
        $model = new Pedidoitem();
        $filter->idPedidoItem = $this->data->idPedidoItem;
        $this->data->query = $model->listByFilter($filter)->asQuery();
        $this->render();
    }

    public function save() {
            $pedidoitem = new Pedidoitem($this->data->pedidoitem);
            $pedidoitem->save();
            $go = '>pedidos/pedidoitem/formObject/' . $pedidoitem->getId();
            $this->renderPrompt('information','OK',$go);
    }

    public function delete() {
            $pedidoitem = new Pedidoitem($this->data->id);
            $pedidoitem->delete();
            $go = '>pedidos/pedidoitem/formFind';
            $this->renderPrompt('information',"Pedidoitem [{$this->data->idPedidoItem}] removido.", $go);
    }

}