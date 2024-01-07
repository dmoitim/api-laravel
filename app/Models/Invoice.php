<?php

namespace App\Models;

use App\Filters\InvoiceFilter;
use App\Http\Resources\InvoiceResourceCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'paid',
        'payment_date',
        'value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filter(Request $request)
    {
        $queryFilter = (new InvoiceFilter)->filter($request);

        if (empty($queryFilter)) {
            return new InvoiceResourceCollection(Invoice::with('user')->get());
        }

        $data = Invoice::with('user');

        if (!empty($queryFilter['whereIn'])) {
            foreach ($queryFilter['whereIn'] as $value) {
                $data->whereIn($value[0], $value[1]);
            }
        }

        $resource = $data->where($queryFilter['where']);

        return new InvoiceResourceCollection($resource->get()); 
    }
}
