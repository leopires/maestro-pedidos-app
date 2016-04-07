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

use pedidos\models\Cliente as Cliente;

class ClienteController extends MController {

    public function main() {
        $this->render("formBase");
    }

    public function formFind() {
        mdump($this->data);
        $cliente = new Cliente();
        $filter = new stdClass();
        $filter->nome = $this->data->txtNomeCliente;
        $this->data->query = $cliente->listByFilter($filter)->asQuery();
        $this->render();
    }

    public function formNew() {
        $this->data->action = '@pedidos/cliente/save';
        $this->render();
    }

    public function formObject() {
        $this->data->cliente = Cliente::create($this->data->id)->getData();
        $this->render();
    }

    public function formUpdate() {
        $cliente = new Cliente($this->data->id);
        mdump($cliente->getData());
        $this->data->cliente = $cliente->getData();
        $this->data->action = '@pedidos/cliente/save/' . $this->data->id;
        $this->render();
    }

    public function formDelete() {
        $cliente = new Cliente($this->data->id);
        $ok = '>pedidos/cliente/delete/' . $cliente->getId();
        $cancelar = '>pedidos/cliente/formObject/' . $cliente->getId();
        $this->renderPrompt('confirmation', "Confirma remoção do Cliente [{cliente->getDescription()}] ?", $ok, $cancelar);
    }

    public function lookup() {
        $model = new Cliente();
        $filter->idCliente = $this->data->idCliente;
        $this->data->query = $model->listByFilter($filter)->asQuery();
        $this->render();
    }

    public function save() {
        $cliente = new Cliente($this->data->id);
        $cliente->setNome($this->data->cliente->nome);
        $cliente->setEmail($this->data->cliente->email);
        $cliente->setTelefone($this->data->cliente->telefone);
        $cliente->save();
        $go = '>pedidos/cliente/formObject/' . $cliente->getId();
        $this->renderPrompt('information', 'Dados do cliente: ' . $cliente->getNome() . ' gravados com sucesso.', $go);
    }

    public function delete() {
        $cliente = new Cliente($this->data->id);
        $cliente->delete();
        $go = '>pedidos/cliente/formFind';
        $this->renderPrompt('information', "Cliente [{$this->data->idCliente}] removido.", $go);
    }

}
