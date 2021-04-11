<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $table = "saving";

    public function mes()
    {
        return $this->belongsTo(Meses::class, "mes_id", "id");
    }
}
