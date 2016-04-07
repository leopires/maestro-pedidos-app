<?php
/**
 * $_comment
 *
 * @category   Maestro
 * @package    UFJF
 * @subpackage $_package
 * @copyright  Copyright (c) 2003-2012 UFJF (http://www.ufjf.br)
 * @license    http://siga.ufjf.br/license
 * @version    
 * @since      
 */

Manager::import("pedidos\models\*");

class PedidoController extends MController {

    public function main() {
        $this->render("formBase");
    }

    public function formFind() {
        $pedido= new Pedido($this->data->id);
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
        $pedido= new Pedido($this->data->id);
        $this->data->pedido = $pedido->getData();
        $this->data->pedido->idVendedorDesc = $pedido->getVendedor()->getDescription();
	
        $this->data->action = '@pedidos/pedido/save/' .  $this->data->id;
        $this->render();
    }

    public function formDelete() {
        $pedido = new Pedido($this->data->id);
        $ok = '>pedidos/pedido/delete/' . $pedido->getId();
        $cancelar = '>pedidos/pedido/formObject/' . $pedido->getId();
        $this->renderPrompt('confirmation', "Confirma remoção do Pedido [{pedido->getDescription()}] ?", $ok, $cancelar);
    }

    public function lookup() {
        $model = new Pedido();
        $filter->idPedido = $this->data->idPedido;
        $this->data->query = $model->listByFilter($filter)->asQuery();
        $this->render();
    }

    public function save() {
            $pedido = new Pedido($this->data->pedido);
            $pedido->save();
            $go = '>pedidos/pedido/formObject/' . $pedido->getId();
            $this->renderPrompt('information','OK',$go);
    }

    public function delete() {
            $pedido = new Pedido($this->data->id);
            $pedido->delete();
            $go = '>pedidos/pedido/formFind';
            $this->renderPrompt('information',"Pedido [{$this->data->idPedido}] removido.", $go);
    }

}