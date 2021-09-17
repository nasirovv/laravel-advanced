<?php

namespace Tests\Unit;

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


    }
}
