<?php

Manager::import("pedidos\models\*");

class ProdutoController extends MController {

    private $situacoesProduto;

    public function init() {
        parent::init();
        $this->situacoesProduto = array("" => "Selecione", "1" => "Ativo", "0" => "Inativo");
    }

    public function main() {
        $this->render("formBase");
    }

    public function formFind() {

        try {
            $produto = new Produto($this->data->id);
            $filter->idProduto = $this->data->idProduto;
            $this->data->query = $produto->listByFilter($filter)->asQuery();
            $this->render();
        } catch (Exception $ex) {
            
        }
    }

    public function formNew() {
        $this->data->situacoesProduto = $this->situacoesProduto;
        $this->data->action = '@pedidos/produto/save';
        $this->render();
    }

    public function formObject() {
        $this->data->produto = Produto::create($this->data->id)->getData();
        $this->render();
    }

    public function formUpdate() {
        $produto = new Produto($this->data->id);
        $this->data->produto = $produto->getData();

        $this->data->action = '@pedidos/produto/save/' . $this->data->id;
        $this->render();
    }

    public function formDelete() {
        $produto = new Produto($this->data->id);
        $ok = '>pedidos/produto/delete/' . $produto->getId();
        $cancelar = '>pedidos/produto/formObject/' . $produto->getId();
        $this->renderPrompt('confirmation', "Confirma remoção do Produto [{produto->getDescription()}] ?", $ok, $cancelar);
    }

    public function lookup() {
        $model = new Produto();
        $filter->idProduto = $this->data->idProduto;
        $this->data->query = $model->listByFilter($filter)->asQuery();
        $this->render();
    }

    public function save() {
        try {
            mdump($this->data);
            $produto = new Produto($this->data->produto);
            $produto->save();
            $go = '>pedidos/produto/formObject/' . $produto->getId();
            $this->renderPrompt(MPrompt::MSG_TYPE_INFORMATION, 'Dados do produto gravados com sucesso.', $go);
        } catch (Exception $ex) {
            $this->renderPrompt(MPrompt::MSG_TYPE_ERROR, $ex->getMessage());
        }
    }

    public function delete() {
        $produto = new Produto($this->data->id);
        $produto->delete();
        $go = '>pedidos/produto/formFind';
        $this->renderPrompt('information', "Produto [{$this->data->idProduto}] removido.", $go);
    }

}
