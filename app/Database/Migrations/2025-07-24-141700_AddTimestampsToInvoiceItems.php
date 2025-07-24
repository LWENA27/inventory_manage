<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddTimestampsToInvoiceItems extends Migration
{
    public function up()
    {
        $fields = [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'total',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at',
            ],
        ];
        $this->forge->addColumn('invoice_items', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('invoice_items', ['created_at', 'updated_at']);
    }
}
