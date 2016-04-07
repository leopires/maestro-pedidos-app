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

class ProdutoController extends MController {

    public function main() {
        $this->render("formBase");
    }

    public function formFind() {
        $produto= new Produto($this->data->id);
        $filter->idProduto = $this->data->idProduto;
        $this->data->query = $produto->listByFilter($filter)->asQuery();
        $this->render();
    }

    public function formNew() {
        $this->data->action = '@pedidos/produto/save';
        $this->render();
    }

    public function formObject() {
        $this->data->produto = Produto::create($this->data->id)->getData();
        $this->render();
    }

    public function formUpdate() {
        $produto= new Produto($this->data->id);
        $this->data->produto = $produto->getData();
        
        $this->data->action = '@pedidos/produto/save/' .  $this->data->id;
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
            $produto = new Produto($this->data->produto);
            $produto->save();
            $go = '>pedidos/produto/formObject/' . $produto->getId();
            $this->renderPrompt('information','OK',$go);
    }

    public function delete() {
            $produto = new Produto($this->data->id);
            $produto->delete();
            $go = '>pedidos/produto/formFind';
            $this->renderPrompt('information',"Produto [{$this->data->idProduto}] removido.", $go);
    }

}