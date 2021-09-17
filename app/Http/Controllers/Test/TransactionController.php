<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index(){
        $taxes = (new TransactionService())->calculateTaxes(1);

        return response()->json($taxes, 200);
    }

}
