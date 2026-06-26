<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginConfig extends Model
{
    protected $fillable = [
        'key',
        'image1_path',
        'image2_path',
        'version',
        'login_title',
        'login_subtitle',
        'show_help_text',
    ];

    protected $casts = [
        'show_help_text' => 'boolean',
    ];

    /**
     * Obté la configuració del login per la clau.
     * Si no existeix, retorna els valors per defecte.
     *
     * @param string $key
     * @return array
     */
    public static function getConfig($key = 'default')
    {
        $config = self::where('key', $key)->first();

        if (!$config) {
            return [
                'key' => $key,
                'image1_path' => 'src/logo_govern_illes_balears.png',
                'image2_path' => null,
                'version' => '1.0.0',
                'login_title' => 'INICIAR SESSIÓ',
                'login_subtitle' => null,
                'show_help_text' => true,
            ];
        }

        return $config->toArray();
    }
}
