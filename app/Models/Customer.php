<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table="table_customer";
    protected $fillable =['name' ,'email', 'phone' , 'address'];
    protected $primaryKey = 'id';
}
