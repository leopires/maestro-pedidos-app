<?php

namespace pedidos\models;

class Vendedor extends map\VendedorMap {

    public static function config() {
        return array(
            'log' => array(),
            'validators' => array(
                'nome' => array('notnull', 'notblank'),
                'cpf' => array('notnull', 'notblank'),
                'email' => array('notnull', 'notblank'),
                'dataCadastro' => array('notnull', 'notblank'),
                'dataUltimaAtualizacao' => array('notnull', 'notblank'),
            ),
            'fieldDescription' => array(
                'nome' => 'Nome do vendedor',
                'cpf' => 'CPF do vendedor',
                'email' => 'E-Mail do vendedor',
            ),
            'converters' => array(
                'nome' => array('case' => 'upper'),
                'email' => array('case' => 'upper')
            )
        );
    }

    private function getBasicCriteria() {
        return $this->getCriteria()->select('*');
    }

    public function getDescription() {
        return $this->getNome();
    }

    /**
     * Faz uma pesquina nos Vendedor pelo nome.
     * @param String $nome Nome ou parte do nome a ser pesquisado.
     * @return Criteria Pesquisa a ser executada.
     */
    public function listByNome($nome) {
        $nomeCliente = filter_var($nome, FILTER_SANITIZE_MAGIC_QUOTES);
        return $this->getBasicCriteria()->where("nome LIKE '%{$nomeCliente}%'");
    }

    public function getTotalClientesByIdVendedor($idVendedor = null) {
        try {
            if ($idVendedor) {
                $id_vendedor = $idVendedor;
            } else {
                $id_vendedor = $this->idVendedor;
            }
            $critetia = $this->getCriteria()->select("count(carteiraClientes.idCliente)")->where("idVendedor = " . "{$id_vendedor}");
            $result = $critetia->asQuery()->getResult();
            return $result[0][0];
        } catch (Exception $ex) {
            throw new \EModelException("Ocorreu um erro durante a contagem de clientes do Vendedor.");
        }
    }

    public function getTotalPedidos($idVendedor = null) {

        $pedido = new Pedido();

        if ($idVendedor) {
            return $pedido->getTotalPedidosByIdVendedor($idVendedor);
        }

        return $pedido->getTotalPedidosByIdVendedor($this->idVendedor);
    }

    /**
     * Verifica se o Vendedor já realizou algum pedido.
     * @return boolean Resultado da verificação. 
     * True se existem pedidos realizados pelo vendedor em questão e False se não.
     * @throws ModelException Em caso de algum ocorrer durante a verificação.
     */
    public function realizouAlgumPedido() {
        try {
            $totalPedidosRealizados = $this->getTotalPedidos();
            if ($totalPedidosRealizados > 0) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            throw new ModelException("Ocorreu um erro ao verificar se o vendedor já realizou pedidos.");
        }
    }

    /**
     * Recupera a Carteira de Clientes do Vendedor.
     * @return Criteria Carteira de Clientes do vendedor.
     */
    public function listCarteiraClientes() {
        $cliente = new \Cliente();
        return $cliente->listByVendedor($this->idVendedor);
    }

    public function save() {
        try {
            $this->setCpf(str_replace("-", "", str_replace(".", "", $this->getCpf())));
            if (!$this->isPersistent()) {
                $this->setDataCadastro(\Manager::getSysTime());
            }
            $this->setDataUltimaAtualizacao(\Manager::getSysTime());
            parent::save();
        } catch (\EDataValidationException $ex) {
            throw $ex;
        } catch (\EDBException $ex) {
            throw $this->handleException($ex->getMessage());
        } catch (\Exception $ex) {
            throw new \EModelException("Ocorreu um erro ao gravar os dados do vendedor. Por favor, tente novamente ou contate o suporte.");
        }
    }

    private function handleException($exceptionMessage) {
        if (strpos($exceptionMessage, "Duplicate entry") !== false) {
            if (strpos($exceptionMessage, "cpf")) {
                return new \EModelException("O CPF informado já está cadastrado para outro vendedor.");
            }
            if (strpos($exceptionMessage, "email")) {
                return new \EModelException("O e-mail informado já está cadastrado para outro vendedor.");
            }
        } else {
            return new \EModelException("Ocorreu um erro ao salva os dados do Cliente.");
        }
    }

    public function delete() {

        if ($this->realizouAlgumPedido()) {
            throw new ModelException("Não é possível excluir este vendedor pois ele já realizou pedidos no Sistema.");
        }

        $transacao = $this->beginTransaction();
        try {
            $this->deleteAssociation("carteiraClientes");
            parent::delete();
            $transacao->commit();
        } catch (Exception $ex) {
            $transacao->rollback();
            throw new ModelException("Ocorreu um erro excluir o vendedor. Por favor, tente novamente ou contate o suporte.");
        }
    }

    /**
     * Adiciona um novo Cliente à Carteita de Clientes do Vendedor.
     * @param \pedidos\models\Cliente $cliente Cliente a ser adicionado à Carteira de Clientes.
     * @throws \EModelException
     */
    public function addNovoClienteCarteira($cliente) {
        try {
            if ($this->pertenceACarteiraClientes($cliente)) {
                throw new \EModelException("O Cliente informado já faz parte da Carteira de Clientes deste vendedor.");
            }
            $this->getAssociationCarteiraClientes();
            $this->carteiraClientes->append($cliente);
            $this->saveAssociation('carteiraClientes');
        } catch (\EModelException $mEx) {
            throw $mEx;
        } catch (\Exception $ex) {
            throw new \EModelException("Ocorreu um erro ao adicionar o cliente na Carteira de Clientes.", 0, $ex);
        }
    }

    public function pertenceACarteiraClientes($cliente) {
        try {
            $this->getAssociationCarteiraClientes();

            foreach ($this->carteiraClientes as $clienteDaCarteira) {
                if ($cliente->getIdCliente() == $clienteDaCarteira->getIdCliente()) {
                    return true;
                }
            }
            return false;
        } catch (\Exception $ex) {
            throw new ModelException("Ocorreu ao verificar se o cliente pertence à Carteira de Clientes.", 0, $ex);
        }
    }

    public function removeClienteDaCarteira($cliente) {
        try {
            $this->deleteAssociationObject("carteiraClientes", $cliente);
        } catch (Exception $ex) {
            throw new ModelException("Ocorreu um erro ao realizar a remoção do cliente da Carteira de Clientes.");
        }
    }

}

?>