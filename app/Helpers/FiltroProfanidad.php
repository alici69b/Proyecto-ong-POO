<?php

class FiltroProfanidad
{
    private static array $palabras = [
        'puta', 'puto', 'putas', 'putos',
        'polla', 'pollas',
        'coño', 'coños',
        'cabron', 'cabrón', 'cabrona', 'cabronada',
        'gilipollas', 'gilipuertas',
        'hijoputa', 'hijo de puta', 'hijos de puta', 'hijaputa', 'hija de puta',
        'mierda', 'mierdas',
        'cagada', 'cagado', 'cagar', 'cagarla',
        'culo', 'culos',
        'teta', 'tetas',
        'maricon', 'maricón', 'maricona',
        'zorra', 'zorro', 'zorras',
        'joder', 'jodido', 'jodiendo', 'jodedor',
        'follar', 'follada', 'follado', 'follon',
        'chingar', 'chingado', 'chingada',
        'pendejo', 'pendeja', 'pendejos', 'pendejas',
        'wey', 'güey',
        'verga', 'vergas',
        'chinga', 'chingue', 'chingues',
        'carajo', 'carajos',
        'conchetumare', 'conchesumare',
        'boludo', 'boluda', 'boludos', 'boludas',
        'imbecil', 'imbécil', 'idiota', 'idiots',
        'estupido', 'estúpido', 'estupida', 'estúpida',
        'tonto', 'tonta', 'tontos', 'tontas', 'tontito',
        'retrasado', 'retrasada',
        'subnormal',
        'bastardo', 'bastarda',
        'malparido', 'malparida',
        'huevon', 'huevón', 'huevona', 'huevada',
        'pajero', 'pajera', 'pajero', 'pajera',
        'masturbarse', 'masturbacion', 'masturbación',
        'porno', 'pornografia', 'pornografía',
        'puteria', 'puteria',
        'prostituta', 'prostituto', 'prostitucion', 'prostitución',
        'nazi', 'racista', 'facha', 'fachas',
        'cerdo', 'cerda', 'cochina', 'cochino',
        'asqueroso', 'asquerosa', 'asquerosidad',
        'pedo', 'pedos', 'pedorro', 'pedorriento',
    ];

    public static function limpiar(string $texto): string
    {
        $patron = '/\b(' . implode('|', array_map('preg_quote', self::$palabras)) . ')\b/i';
        return preg_replace($patron, '***', $texto);
    }

    public static function contieneProfanidad(string $texto): bool
    {
        $patron = '/\b(' . implode('|', array_map('preg_quote', self::$palabras)) . ')\b/i';
        return (bool) preg_match($patron, $texto);
    }
}
