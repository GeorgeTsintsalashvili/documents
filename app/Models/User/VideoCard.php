<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Library\Paginator;

class VideoCard extends Model
{
  public $timestamps = false;
  protected $fillable = ['title', 'price', 'discount', 'conditionId', 'stockTypeId', 'visibility', 'configuratorPart'];
}
