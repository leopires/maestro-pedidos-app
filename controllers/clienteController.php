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
use pedidos\exceptions\ModelException as ModelException;

class ClienteController extends MController {

    public function main() {
        $this->render("formBase");
    }

    public function formFind() {

        try {
            $cliente = new Cliente();
            $nome = $this->data->nomeCliente;
            $this->data->query = $cliente->listByNome($nome)->asQuery();
        } catch (Exception $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, "Aconteceu um erro durante a busca do Cliente. Por favor, tente novamente ou contate o suporte.");
        } finally {
            $this->render();
        }
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

        try {
            $cliente = new Cliente($this->data->id);
            $ok = '>pedidos/cliente/delete/' . $cliente->getId();
            $cancelar = '>pedidos/cliente/formObject/' . $cliente->getId();
            $this->renderPrompt('confirmation', "Deseja realmente excluir o Cliente " . $cliente->getDescription() . "?", $ok, $cancelar);
        } catch (Exception $ex) {
            $this->renderPrompt("Não foi possível excluir o Cliente devido: " . $ex->getMessage());
        }
    }

    public function lookup() {

        try {
            $cliente = new Cliente();
            $this->data->query = $cliente->listByNome($this->data->nomeCliente);
            $this->render();
        } catch (Exception $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, "Erro ao abrir lookup para pesquisa de Clientes.");
        }
    }

    public function save() {

        try {
            $cliente = new Cliente($this->data->id);
            $cliente->setNome($this->data->cliente->nome);
            $cliente->setEmail($this->data->cliente->email);
            $cliente->setTelefone($this->data->cliente->telefone);
            $cliente->save();
            $go = '>pedidos/cliente/formObject/' . $cliente->getId();
            $this->renderPrompt('information', 'Dados do cliente: ' . $cliente->getNome() . ' gravados com sucesso.', $go);
        } catch (ModelException $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, $ex->getMessage());
        }
    }

    public function delete() {

        try {
            $cliente = new Cliente($this->data->id);
            $cliente->delete();
            $go = '>pedidos/cliente/formFind';
            $this->renderPrompt('information', "Cliente removido com sucesso.", $go);
        } catch (Exception $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, "Erro ao remover o Cliente. " . $ex->getMessage());
        }
    }

}
