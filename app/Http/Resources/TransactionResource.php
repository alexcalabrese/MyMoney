<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category;
use App\Models\State;
use App\Models\Timing;
use App\Models\Method;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'total'             => $this->total,
            'notes'             => $this->notes,
            'date'              => $this->date,
            'type'              => $this->type,
            'readableTotal'     => $this->type . $this->total,
            'category'          => Category::find($this->category_id)->name,
            'state'             => State::find($this->state_id)->name,
            'timing'            => Timing::find($this->timing_id)->name,
            'method'            => Method::find($this->method_id)->name,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
