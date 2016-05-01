<?php

namespace pedidos\models;

class Produto extends map\ProdutoMap {

    public static function config() {
        return array(
            'log' => array(),
            'validators' => array(
            ),
            'converters' => array()
        );
    }

    public function listByFilter($filter = null) {
        
        $criteria = $this->getCriteria()->select('*')->orderBy("nome");

        if ($filter->nomeProduto) {
            $criteria->where("nome LIKE '%{$filter->nomeProduto}%'");
        }

        if ($filter->codigoEAN) {
            $criteria->where("codigoEAN = '{$filter->codigoEAN}'");
        }
        if (($filter->situacao == "0") || ($filter->situacao == "1")) {
            $criteria->where("ativo = {$filter->situacao}");
        }

        return $criteria;
    }
    
    public function listAllProdutosAtivos() {
        $filter = new \stdClass();
        $filter->situacao = "1";
        return $this->listByFilter($filter);
    }

    public static function listStatusProduto() {
        return array(1 => "Ativo", 0 => "Inativo");
    }

    public function getDescription() {
        return $this->getNome();
    }

    public function save() {
        try {
            if (!$this->isPersistent()) {
                $this->setDataCadastro(\Manager::getSysTime());
            }
            $this->setDataUltimaAtualizacao(\Manager::getSysTime());
            parent::save();
        } catch (\EDataValidationException $ex) {
            throw new \EModelException($ex->getMessage());
        } catch (\EDBException $ex) {
            throw $this->handleException($ex->getMessage());
        } catch (\Exception $ex) {
            throw new \EModelException("Ocorreu um erro ao salvar os dados do Produto. Por favor, tente novamente ou contate o suporte.");
        }
    }

    private function handleException($exceptionMessage) {
        return new \EModelException($exceptionMessage);
    }

}

?>