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

use pedidos\models\Vendedor as Vendedor;
use pedidos\models\Cliente as Cliente;
use pedidos\exceptions\ModelException as ModelException;

class VendedorController extends MController {

    public function main() {
        $this->render("formBase");
    }

    public function formFind() {
        $vendedor = new Vendedor();
        try {
            $this->data->query = $vendedor->listByNome($this->data->nomeVendedor)->asQuery();
            $this->render();
        } catch (Exception $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, "Ocorreu um erro durante a pesquisa. Por favor, tente novamente ou contate o suporte.");
        }
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
        $vendedor = new Vendedor($this->data->id);
        $this->data->vendedor = $vendedor->getData();

        $this->data->action = '@pedidos/vendedor/save/' . $this->data->id;
        $this->render();
    }

    public function formDelete() {

        try {
            $vendedor = new Vendedor($this->data->id);
            $ok = '>pedidos/vendedor/delete/' . $vendedor->getId();
            $cancelar = '>pedidos/vendedor/formObject/' . $vendedor->getId();
            $this->renderPrompt('confirmation', "Tem certeza que deseja excluir o Vendedor {$vendedor->getDescription()}?", $ok, $cancelar);
        } catch (Exception $ex) {
            $this->promptError("Ocorreu um erro ao recuperar os dados do Vendedor para exclusão.");
        }
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
        $this->renderPrompt('information', 'OK', $go);
    }

    public function delete() {
        try {
            $vendedor = new Vendedor($this->data->id);
            $vendedor->delete();
            $go = '>pedidos/vendedor/formFind';
            $this->renderPrompt('information', "Vendedor {$this->data->idVendedor} removido com sucesso.", $go);
        } catch (Exception $ex) {
            $this->promptError($ex->getMessage());
        }
    }

    public function formCarteiraClientes() {

        try {
            if ($this->data->id) {
                $vendedor = new Vendedor($this->data->id);
                $this->data->title = "Carteira de clientes de " . $vendedor->getNome();
                $this->data->query = $vendedor->listCarteiraClientes()->asQuery();
                $this->render();
            }
        } catch (Exception $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, "Ocorreu um erro ao listar a Carteira de Clientes do vendedor.");
        }
    }

    public function addClienteCarteira() {

        $go = "";

        try {
            if ($this->data->idCliente) {
                $vendedor = $this->getVendedor($this->data->idVendedor);
                $go = '>pedidos/vendedor/formCarteiraClientes/' . $vendedor->getId();
                $vendedor->addNovoClienteCarteira(new Cliente($this->data->idCliente));
                $this->promptInformation("Carteira de Clientes atualizada com sucesso.", $go);
            }
        } catch (ModelException $ex) {
            $this->promptError($ex->getMessage(), $go);
        } catch (Exception $ex) {
            $this->promptError("Ocorreu um erro ao atualizar a Carteira de Clientes. Por favor, tente novamente ou contate o suporte.", $go);
        }
    }

    public function removeClienteCarteira() {

        $go = "";
        try {
            if (($this->data->idVendedor) && ($this->data->id)) {
                $vendedor = $this->getVendedor($this->data->idVendedor);
                $go = '>pedidos/vendedor/formCarteiraClientes/' . $vendedor->getId();
                $vendedor->removeClienteDaCarteira(new Cliente($this->data->id));
                $this->promptInformation("Cliente removido com sucesso da Carteira de Clientes do vendedor.", $go);
            }
        } catch (ModelException $ex) {
            $this->promptError($ex->getMessage(), $go);
        } catch (Exception $ex) {
            $this->promptError("Ocorreu um erro ao remover o cliente da Carteira de Clientes.", $go);
        }
    }

    private function getVendedor($idVendedor) {
        return new Vendedor($idVendedor);
    }

    private function promptError($menssage, $go = '') {
        $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, $menssage, $go);
    }

    private function promptInformation($message, $go = '') {
        $this->renderPrompt(MPrompt::MSG_TYPE_INFORMATION, $message, $go);
    }

}
