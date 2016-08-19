<?php

use pedidos\models\Cliente as Cliente;

class ClienteController extends MController {

    const ACTION_PEDIDOS_MAIN = ">pedidos/main";
    const ACTION_PEDIDOS_CLIENTE_FORM_FIND = ">pedidos/cliente/formFind";

    public function main() {
        $this->redirect(Manager::getURL(self::ACTION_PEDIDOS_CLIENTE_FORM_FIND));
    }

    public function formFind() {
        try {
            $cliente = new Cliente();
            $nome = $this->data->nomeCliente;
            $this->data->query = $cliente->listByNome($nome)->asQuery();
            $this->render();
        } catch (Exception $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, "Ocorreu um erro ao listar os Clientes. Por favor, tente novamente ou contate o suporte.", self::ACTION_PEDIDOS_MAIN);
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
        } catch (Exception $ex) {
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
