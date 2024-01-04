<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    private array $types = [
        'B' => 'Boleto',
        'C' => 'Cartão',
        'P' => 'Pix'
    ];

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'firstName' => $this->user->firstName,
                'lastName' => $this->user->lastName,
                'fullName' => $this->user->firstName . ' ' . $this->user->lastName,
                'email' => $this->user->email
            ],
            'type' => $this->types[$this->type],
            'paid' => $this->paid ? 'Pago' : 'Não pago',
            'value' => 'R$ ' . number_format($this->value, 2, ',', '.'),
            'payment_date' => $this->paid ? Carbon::parse($this->payment_date)->format('d/m/Y H:i:s') : NULL,
            'payment_since' => $this->paid ? Carbon::parse($this->payment_date)->diffForHumans() : NULL
        ];
    }
}
