<?php

namespace Tests\Unit;

use App\Models\Income;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaxesTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_found_user_returns_zero_taxes()
    {
        $taxes = (new TransactionService())->calculateTaxes(1);
        $this->assertEquals(0, $taxes);
    }

    public function test_not_taxed_user_is_not_taxed(){
        $user = User::factory()->create(['isTaxed' => false]);
        $taxes = (new TransactionService())->calculateTaxes($user->id);
        $this->assertEquals(0, $taxes);

        $transaction = Income::factory()->create(['user_id' => $user->id]);
        $this->assertEquals(0, $taxes);
    }

    public function test_income_above_50000_is_taxed_at_20_percent(){
        $income = 60000;
        $user = User::factory()->create();
        $transaction = Income::factory()->create([
            'user_id' => $user->id,
            'amount' => $income
            ]);

        $taxes = (new TransactionService())->calculateTaxes($user->id);
        $this->assertEquals($income * 0.2, $taxes);
    }

    public function test_income_below_50000_is_taxed_at_15_percent(){
        $income = 40000;
        $user = User::factory()->create();
        $transaction = Income::factory()->create([
            'user_id' => $user->id,
            'amount' => $income
        ]);

        $taxes = (new TransactionService())->calculateTaxes($user->id);
        $this->assertEquals($income * 0.15, $taxes);
    }
}
