<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{

    protected $guarded = ['id'];

    protected $casts = [
        'shortcode' => 'object',
    ];

    public function scopeGenerateScript()
    {
        $script = $this->script;
        foreach ($this->shortcode as $key => $item) {
            $script = shortCodeReplacer('{{' . $key . '}}', $item->value, $script);
        }
        return $script;
    }
}
