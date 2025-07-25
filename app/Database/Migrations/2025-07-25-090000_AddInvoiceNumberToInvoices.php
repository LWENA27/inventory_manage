<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddInvoiceNumberToInvoices extends Migration
{
    public function up()
    {
        $fields = [
            'invoice_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'id',
            ],
        ];
        $this->forge->addColumn('invoices', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('invoices', 'invoice_number');
    }
}
