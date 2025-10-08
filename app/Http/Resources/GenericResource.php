<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenericResource extends JsonResource
{
    protected $fields;

    public function __construct($resource, $fields = null)
    {
        parent::__construct($resource);
        $this->fields = $fields;
    }

    public function toArray($request)
    {
        $data = parent::toArray($request);

        if ($this->fields && is_array($this->fields)) {
            // يرجع فقط الحقول المطلوبة
            return collect($data)->only($this->fields)->toArray();
        }

        return $data;
    }
}
