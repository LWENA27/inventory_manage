<?php
if (!function_exists('stock_operation_label')) {
    function stock_operation_label($operation)
    {
        switch ($operation) {
            case 'in':
                return lang('stock.stockIn');
            case 'out':
                return lang('stock.stockOut');
            case 'adjust':
                return lang('stock.adjustment');
            default:
                return $operation;
        }
    }
}
