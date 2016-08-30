<?php

namespace pedidos\models;

class Cliente extends map\ClienteMap {

    public static function config() {
        return array(
            'log' => array(),
            'validators' => array(
                'nome' => array('notnull', 'notblank'),
                'email' => array('notnull', 'notblank'),
                'telefone' => array('notnull', 'notblank'),
                'dataCadastro' => array('notnull', 'notblank'),
                'dataUltimaAtualizacao' => array('notnull', 'notblank'),
            ),
            'fieldDescription' => array(
                'nome' => 'Nome do cliente',
                'email' => 'E-Mail do cliente',
                'telefone' => 'Telefone do cliente'
            ),
            'converters' => array(
                'nome' => array('case' => 'upper'),
                'email' => array('case'=> 'upper')
            )
        );
    }

    public function getDescription() {
        return $this->getNome();
    }

    private function getBasicCriteria() {
        $criteria = $this->getCriteria()->select('*');
        return $criteria;
    }

    /**
     * Permite que Clientes possam ser encontrados pelo nome.
     * @param String $nome Nome ou parte do nome a ser pesquisado.
     * @return \PersistentCriteria Pesquisa a ser executada.
     */
    public function listByNome($nome) {
        $nomeCliente = filter_var($nome, FILTER_SANITIZE_STRING);
        return $this->getBasicCriteria()->where("nome LIKE '%{$nomeCliente}%'")->orderBy("nome");
    }

    /**
     * Recupera os Clientes de um determinado vendedor.
     * @param integer $idVendedor Vendedor o qual se quer recuperar a lista de Clientes.
     * @return \PersistentCriteria
     */
    public function listByVendedor($idVendedor) {
        return $this->getBasicCriteria()->where("vendedores.idVendedor = " . "{$idVendedor}");
    }

    public function listByVendedorAndNome($idVendedor, $nomeVendedor = null) {
        $criteria = $this->listByVendedor($idVendedor);
        if ($nomeVendedor) {
            $nome = filter_var($nomeVendedor, FILTER_SANITIZE_MAGIC_QUOTES);
            $criteria->where("nome LIKE '%{$nome}%'");
        }
        return $criteria;
    }

    /**
     * Salva os dados do Cliente criando um novo registro ou atualizando um cliente já existente.
     * @throws \EModelException Caso algum erro ocorra durante a gravação dos dados.
     */
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
            throw new \EModelException("Ocorreu um erro ao salvar o dados do cliente. Por favor, tente novamente ou contate o suporte.");
        }
    }

    /**
     * Trata a mensagem de excessão.
     * @param string $exceptionMessage
     * @return \EModelException
     */
    private function handleException($exceptionMessage) {
        if ((strpos($exceptionMessage, "Duplicate entry") !== false) && (strpos($exceptionMessage, "email"))) {
            return new \EModelException("O e-mail informado já está cadastrado para outra pessoa.");
        } else {
            return new \EModelException("Ocorreu um erro ao salva os dados do Cliente.");
        }
    }
    
}

?>