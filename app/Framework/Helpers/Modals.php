<?php

namespace App\Framework\Helpers;

class Modals
{
    public static function Alert($id, $title, $text, $type, $icon, $params = [], $action)
    {
        return [
            'id' => $id,
            'title' => $title,
            'text' => $text,
            'type' => $type,
            'icon' => $icon,
            'param' => $params,
            'action' => $action
        ];
    }
}
