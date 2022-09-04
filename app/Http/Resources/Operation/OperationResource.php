<?php

namespace App\Http\Resources\Operation;

use Illuminate\Http\Resources\Json\JsonResource;

class OperationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'status' => $this->status,
            'account' => $this->account,
            'amount' => $this->amount,
            'balance' => $this->balance,
            'options' => $this->options,
            'updated_at' => $this->updated_at,
        ];
    }
}
