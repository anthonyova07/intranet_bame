<?php
echo "# Tarjeta,Idenficacion,Nombre Plastico,Descripcion,Moneda,Monto,Tipo TRX,Concepto,Fecha de Proceso,Fecha de TRX,BIN\n";
foreach ($transactions as $transaction_collect) {
    foreach ($transaction_collect as $transaction) {
        echo $transaction->getCreditCard() . "*," .
            ($transaction->creditcard ? trim($transaction->creditcard->getIdentification()) . "*," . $transaction->creditcard->getPlasticName() . "," : ",,") .
            str_replace(',', ' ', $transaction->getDescription()) . "," .
            ($transaction->getCurrency() == '214' ? "DOP," : "USD,") .
            $transaction->getAmount() . "," .
            $transaction->transaction_type->getDescription() . "," .
            $transaction->transaction_concep->getDescription() . "," .
            $transaction->getProcessDate() . "," .
            $transaction->getTransactionDate() . "," .
            substr($transaction->getCreditCard(), 0, 6) . "\n";
    }
}
?>
@include('layouts.partials.csv_file')
