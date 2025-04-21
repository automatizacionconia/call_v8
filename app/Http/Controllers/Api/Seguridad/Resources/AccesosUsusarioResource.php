<?php

namespace App\Http\Controllers\Api\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class AccesosUsusarioResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'acce_codigo' => $this->ACCE_CODIGO,
            'usua_codigo' => $this->USUA_CODIGO,
            'acce_estado' => $this->ACCE_ESTADO,
            'opci_codigo' => optional($this->opciones)->OPCI_CODIGO ?? '',
            'opci_tipo' => optional($this->opciones)->OPCI_TIPO ?? '',
            'opci_sub_codigo' => optional($this->opciones)->OPCI_SUB_CODIGO,
            'opci_icon' => optional($this->opciones)->OPCI_ICON,
            'opci_href' => optional($this->opciones)->OPCI_HREF,
            'opci_nombre' => optional($this->opciones)->OPCI_NOMBRE ?? '',
            'opci_sub_nombre' => optional($this->opciones)->OPCI_SUB_NOMBRE,
            'opci_icon_notifica' => optional($this->opciones)->OPCI_ICON_NOTIFICA,
            'opci_order' => optional($this->opciones)->OPCI_ORDER,
            'opci_estado' => optional($this->opciones)->OPCI_ESTADO,
            'subopciones' => OpcionesResource::collection($this->opciones->subOpciones ?? []),
        ];
    }

}
