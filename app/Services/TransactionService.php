<?php

namespace App\Services;

use App\Models\Income;
use App\Models\User;

class TransactionService {

    public function calculateTaxes($userId){
        $user = User::find($userId);
        if($user){
            if ($user->isTaxed){
                $income = Income::where('user_id', $userId)
                    ->sum('amount');
                if($income > 50000){
                    $taxes = $income * 0.2;
                }else{
                    $taxes = $income * 0.15;
                }
            }
            else{
                $taxes = 0;
            }
        }
        else{
            $taxes = 0;
        }

        return $taxes;
    }

}
