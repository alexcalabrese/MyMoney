<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category;
use App\Models\State;
use App\Models\Timing;
use App\Models\Method;
use Illuminate\Support\Carbon;

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
            'date'              => Carbon::parse($this->date)->format('d-m-Y'),
            'type'              => $this->type,
            'readableTotal'     => $this->type . $this->total,
            'category_id'       => Category::find($this->category_id)->id,
            'category_label'    => Category::find($this->category_id)->name,
            'category_icon'     => Category::find($this->category_id)->icon,
            'category_color'    => Category::find($this->category_id)->color,
            'state_id'          => State::find($this->state_id)->id,
            'state_label'       => State::find($this->state_id)->name,
            'timing_id'         => Timing::find($this->timing_id)->id,
            'timing_label'      => Timing::find($this->timing_id)->name,
            'method_id'         => Method::find($this->method_id)->id,
            'method_label'      => Method::find($this->method_id)->name,
            'label_id'          => $this->labels->pluck('id')->isEmpty() == true ? null : $this->labels->pluck('id'),
            'label_name'        => $this->labels->pluck('name')->isEmpty() == true ? null : $this->labels->pluck('name'),
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
