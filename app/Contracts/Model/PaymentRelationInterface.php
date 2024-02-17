<?php 

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface PaymentRelationInterface{
    public function payment(): MorphOne;

    public function payments(): MorphMany;
}