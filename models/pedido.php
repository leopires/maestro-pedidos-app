<?php

namespace pedidos\models;

class Pedido extends map\PedidoMap {

    public static $PEDIDO_SITUACAO_NOVO = 1;
    public static $PEDIDO_SITUACAO_EMITIDO = 2;
    public static $PEDIDO_SITUACAO_FATURADO = 3;
    public static $PEDIDO_SITUACAO_CANCELADO = 4;

    public static function config() {
        return array(
            'log' => array(),
            'validators' => array(
                'idVendedor' => array('notnull', 'notblank'),
                'idCliente' => array('notnull', 'notblank'),
                'situacao' => array('notnull', 'notblank'),
                'dataCriacao' => array('notnull', 'notblank'),
                'dataUltimaAlteracao' => array('notnull', 'notblank'),
            ),
            'fieldDescription' => array(
                'idVendedor' => 'Vendedor do pedido',
                'idCliente' => 'Cliente do pedido',
                'situacao' => 'Situação do pedido'
            ),
            'converters' => array()
        );
    }

    public static function formataNumeroPedido($idPedido) {
        return str_pad($idPedido, 9, '0', STR_PAD_LEFT);
    }

    public static function getDescricaoSituacao($situacao) {
        return Pedido::getSituacoes()[$situacao];
    }

    public static function getSituacoes() {
        return array(1 => "NOVO", 2 => "EMITIDO", 3 => "FATURADO", 4 => "CANCELADO");
    }

    public function getNumeroPedidoFormatado() {
        return Pedido::formataNumeroPedido($this->getIdPedido());
    }

    public function getDescription() {
        return "Pedido Nº: " + Pedido::formataNumeroPedido($this->idPedido);
    }

    public function save() {
        try {
            if (!$this->isPersistent()) {
                $this->setDataCriacao(\Manager::getSysTime());
            }
            $this->setDataUltimaAtualizacao(\Manager::getSysTime());
            parent::save();
        } catch (Exception $ex) {
            throw new \EModelException($ex->getMessage());
        }
    }

    public function listAll() {
        $criteria = $this->getCriteria()
                ->select("idPedido")
                ->select("dataCriacao")
                ->select("cliente.nome as cliente")
                ->select("vendedor.nome as vendedor")
                ->select("situacao");

        return $criteria->orderBy("idPedido");
    }

    public function listByNumeroPedido($numeroPedido) {
        $numeroPedido = filter_var($numeroPedido, FILTER_SANITIZE_MAGIC_QUOTES);
        return $this->listAll()->where("idPedido = {$numeroPedido}");
    }
    
    public function listEntreDatas($dataInicio = null, $dataFim = null) {
        
        $criteria = $this->listAll();
        
        if($dataInicio) {
            $dataInicio = filter_var($dataInicio, FILTER_SANITIZE_MAGIC_QUOTES);
            $criteria->where("dataCriacao >= '{$dataInicio}'");
        }
        
        if($dataFim) {
            $dataFim = filter_var($dataFim, FILTER_SANITIZE_MAGIC_QUOTES);
            $criteria->where("dataCriacao <= '{$dataFim}'");
        }
        
        return $criteria;
    }

    /**
     * Dado um determinado Vendedor, recupera o número de pedidos dele.
     * @param Integer $idVendedor Identificador do Vendedor.
     * @return Integer Número de pedidos do Vendedor.
     * @throws \EModelException Caso algum erro ocorra durante a contagem dos pedidos.
     */
    public function getTotalPedidosByIdVendedor($idVendedor) {
        try {
            $criteria = $this->getCriteria()->select("count(idPedido)")->where("vendedor.idVendedor = " . "{$idVendedor}");
            return $criteria->asQuery()->getResult()[0][0];
        } catch (Exception $ex) {
            throw new \EModelException("Ocorreu um erro ao recuperar o total de pedidos do Vendedor.");
        }
    }

    public function calculaValorTotalPedido() {
        $valorTotalPedido = 0;
        try {
            $this->getAssociationItensPedido();
            foreach ($this->itensPedido as $pedidoItem) {
                $totalItem = ($pedidoItem->getProduto()->getPrecoUnitario()->getValue() * $pedidoItem->getQuantidade());
                $valorTotalPedido +=$totalItem;
            }
            return $valorTotalPedido;
        } catch (\Exception $ex) {
            throw new \EModelException("Ocorreu um erro durante o cáculo do valor total do pedido.");
        }
    }

    /**
     * Lista os Itens do Pedido
     * - idPedidoItem
     * - nome : Nome do Produto
     * - quantidade: Quantidade do item.
     * @return type
     */
    public function listItensPedido() {
        $pedidoItem = new Pedidoitem();
        return $pedidoItem->listByIdPedido($this->getIdPedido());
    }

    public function trocaSituacaoPedidoParaEmitido() {
        try {
            $this->trocaSituacaoPedido(Pedido::$PEDIDO_SITUACAO_EMITIDO);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    private function trocaSituacaoPedido($novaSituacao) {
        try {
            $this->setSituacao($novaSituacao);
            $this->save();
        } catch (Exception $ex) {
            throw new \EModelException("Ocorreu um erro ao alterar a situação do pedido.");
        }
    }

}

?>