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

class VendedorController extends MController {

    public function main() {
        $this->render("formBase");
    }

    public function formFind() {
        $vendedor= new Vendedor($this->data->id);
        $filter->idVendedor = $this->data->idVendedor;
        $this->data->query = $vendedor->listByFilter($filter)->asQuery();
        $this->render();
    }

    public function formNew() {
        $this->data->action = '@pedidos/vendedor/save';
        $this->render();
    }

    public function formObject() {
        $this->data->vendedor = Vendedor::create($this->data->id)->getData();
        $this->render();
    }

    public function formUpdate() {
        $vendedor= new Vendedor($this->data->id);
        $this->data->vendedor = $vendedor->getData();
        
        $this->data->action = '@pedidos/vendedor/save/' .  $this->data->id;
        $this->render();
    }

    public function formDelete() {
        $vendedor = new Vendedor($this->data->id);
        $ok = '>pedidos/vendedor/delete/' . $vendedor->getId();
        $cancelar = '>pedidos/vendedor/formObject/' . $vendedor->getId();
        $this->renderPrompt('confirmation', "Confirma remoção do Vendedor [{vendedor->getDescription()}] ?", $ok, $cancelar);
    }

    public function lookup() {
        $model = new Vendedor();
        $filter->idVendedor = $this->data->idVendedor;
        $this->data->query = $model->listByFilter($filter)->asQuery();
        $this->render();
    }

    public function save() {
            $vendedor = new Vendedor($this->data->vendedor);
            $vendedor->save();
            $go = '>pedidos/vendedor/formObject/' . $vendedor->getId();
            $this->renderPrompt('information','OK',$go);
    }

    public function delete() {
            $vendedor = new Vendedor($this->data->id);
            $vendedor->delete();
            $go = '>pedidos/vendedor/formFind';
            $this->renderPrompt('information',"Vendedor [{$this->data->idVendedor}] removido.", $go);
    }

}