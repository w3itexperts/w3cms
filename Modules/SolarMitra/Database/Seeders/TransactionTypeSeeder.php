<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Level 1: Parent types
        $incomeId = DB::table('transaction_types')->insertGetId([
            'title' => 'Income',
            'slug' => 'income',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $expenseId = DB::table('transaction_types')->insertGetId([
            'title' => 'Expense',
            'slug' => 'expense',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Level 2: Income subtypes
        $salesId = DB::table('transaction_types')->insertGetId([
            'parent_id' => $incomeId,
            'title' => 'Sales',
            'slug' => 'sales',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $otherIncomeId = DB::table('transaction_types')->insertGetId([
            'parent_id' => $incomeId,
            'title' => 'Other Income',
            'slug' => 'other-income',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Level 2: Expense subtypes
        $operationalExpensesId = DB::table('transaction_types')->insertGetId([
            'parent_id' => $expenseId,
            'title' => 'Operational Expenses',
            'slug' => 'operational-expenses',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $projectExpensesId = DB::table('transaction_types')->insertGetId([
            'parent_id' => $expenseId,
            'title' => 'Project Expenses',
            'slug' => 'project-expenses',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $hrExpensesId = DB::table('transaction_types')->insertGetId([
            'parent_id' => $expenseId,
            'title' => 'HR Expenses',
            'slug' => 'hr-expenses',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $otherExpensesId = DB::table('transaction_types')->insertGetId([
            'parent_id' => $expenseId,
            'title' => 'Other Expenses',
            'slug' => 'other-expenses',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Level 3: Under Sales
        DB::table('transaction_types')->insert([
            ['parent_id' => $salesId, 'title' => 'Invoice Payment', 'slug' => 'invoice-payment', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $salesId, 'title' => 'Advance from Client', 'slug' => 'advance-from-client', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $salesId, 'title' => 'Direct Sale', 'slug' => 'direct-sale', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Level 3: Under Other Income
        DB::table('transaction_types')->insert([
            ['parent_id' => $otherIncomeId, 'title' => 'Loan Received', 'slug' => 'loan-received', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $otherIncomeId, 'title' => 'Interest Income', 'slug' => 'interest-income', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $otherIncomeId, 'title' => 'Investment', 'slug' => 'investment', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Level 3: Under Operational Expenses
        DB::table('transaction_types')->insert([
            ['parent_id' => $operationalExpensesId, 'title' => 'Office Expenses', 'slug' => 'office-expenses', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $operationalExpensesId, 'title' => 'Transport Expenses', 'slug' => 'transport-expenses', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $operationalExpensesId, 'title' => 'Utility Bills', 'slug' => 'utility-bills', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Level 3: Under Project Expenses
        DB::table('transaction_types')->insert([
            ['parent_id' => $projectExpensesId, 'title' => 'Material Purchase', 'slug' => 'material-purchase', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $projectExpensesId, 'title' => 'Labor Payment', 'slug' => 'labor-payment', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $projectExpensesId, 'title' => 'Contractor Payment', 'slug' => 'contractor-payment', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Level 3: Under HR Expenses
        DB::table('transaction_types')->insert([
            ['parent_id' => $hrExpensesId, 'title' => 'Salary', 'slug' => 'salary', 'created_at' => now(), 'updated_at' => now()],
            ['parent_id' => $hrExpensesId, 'title' => 'Bonus', 'slug' => 'bonus', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Level 3: Under Other Expenses
        DB::table('transaction_types')->insert([
            ['parent_id' => $otherExpensesId, 'title' => 'Misc Expense', 'slug' => 'misc-expense', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
