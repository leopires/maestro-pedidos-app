<?php

class RendersGrid {

    public function gridProdutoSituacaoProduto($value) {
        $control = new MLabel();
        switch ($value) {
            case 0: {
                    $control->setText("INATIVO");
                    $control->setColor("#DF0E18");
                    break;
                }
            case 1: {
                    $control->setText("ATIVO");
                    $control->setColor("#070DED");
                }
        }
        return $control;
    }
    
    public function formataValorCurrency($value) {
        $formatter = new MCurrencyFormatter();
        return $formatter->formatWithSymbol($value);
    }
}
