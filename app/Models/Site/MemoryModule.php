<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class MemoryModule extends Model
{
  public function stockType()
  {
    return $this -> belongsTo(StockType::class, 'stockTypeId');
  }

  public function condition()
  {
    return $this -> belongsTo(Condition::class, 'conditionId');
  }

  public function warranty()
  {
    return $this -> belongsTo(Warranty::class, 'warrantyId');
  }
}
