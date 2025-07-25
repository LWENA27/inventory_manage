<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddTotalAmountToInvoices extends Migration
{
    public function up()
    {
        $fields = [
            'total_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'after' => 'total',
            ],
        ];
        $this->forge->addColumn('invoices', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('invoices', 'total_amount');
    }
}
