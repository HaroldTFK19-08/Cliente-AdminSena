<?php

namespace App\Support;

use Illuminate\Support\Carbon;

/**
 * Pequeños ayudantes para las vistas Blade (registrado como alias "Vista").
 */
class Vista
{
    /** Nombre completo de un usuario de la API. */
    public static function nombre($usuario, string $vacio = 'Sin nombre'): string
    {
        $partes = array_filter([
            data_get($usuario, 'nombre_1'),
            data_get($usuario, 'nombre_2'),
            data_get($usuario, 'apellido_1'),
            data_get($usuario, 'apellido_2'),
        ]);

        return $partes ? implode(' ', $partes) : $vacio;
    }

    /** Iniciales para los avatares. */
    public static function iniciales($usuario): string
    {
        $primera = mb_substr((string) data_get($usuario, 'nombre_1', ''), 0, 1);
        $segunda = mb_substr((string) data_get($usuario, 'apellido_1', ''), 0, 1);

        return mb_strtoupper($primera . $segunda) ?: 'U';
    }

    /** Fecha legible (d/m/Y por defecto). */
    public static function fecha($valor, string $formato = 'd/m/Y', string $vacio = '—'): string
    {
        if (! $valor) {
            return $vacio;
        }

        try {
            return Carbon::parse($valor)->format($formato);
        } catch (\Throwable) {
            return $vacio;
        }
    }

    /** Fecha corta en español: "12 oct 2026". */
    public static function fechaCorta($valor, string $vacio = '—'): string
    {
        if (! $valor) {
            return $vacio;
        }

        try {
            $meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
            $fecha = Carbon::parse($valor);

            return $fecha->day . ' ' . $meses[$fecha->month - 1] . ' ' . $fecha->year;
        } catch (\Throwable) {
            return $vacio;
        }
    }

    /** Fecha en formato Y-m-d para los <input type="date">. */
    public static function fechaInput($valor): string
    {
        return self::fecha($valor, 'Y-m-d', '');
    }

    /** URL pública de un archivo guardado por AdminSena en storage/app/public. */
    public static function archivo(?string $ruta): ?string
    {
        if (! $ruta) {
            return null;
        }

        if (str_starts_with($ruta, 'http')) {
            return $ruta;
        }

        $base = env('URL_STORAGE')
            ?: preg_replace('#/v1/?$#', '', rtrim((string) env('URL_API'), '/')) . '/storage';

        return rtrim($base, '/') . '/' . ltrim($ruta, '/');
    }

    /** Clases de color para las etiquetas de estado. */
    public static function colorEstado(?string $estado): string
    {
        return match (mb_strtolower((string) $estado)) {
            'activo', 'aprobado', 'publicado', 'seleccionado', 'certificado', 'si', 'sí' => 'bg-sena-50 text-sena-700 ring-1 ring-inset ring-sena-200',
            'pendiente', 'en proceso', 'creado', 'registrado' => 'bg-oro-50 text-oro-700 ring-1 ring-inset ring-oro-500/30',
            'reprobado', 'rechazado', 'cancelada', 'inactivo', 'retirado', 'no' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-200',
            default => 'bg-azul-50 text-azul-800 ring-1 ring-inset ring-azul-100',
        };
    }

    /** Color del punto que acompaña cada estado. */
    public static function puntoEstado(?string $estado): string
    {
        return match (mb_strtolower((string) $estado)) {
            'activo', 'aprobado', 'publicado', 'seleccionado', 'certificado' => 'bg-sena-500',
            'pendiente', 'en proceso', 'creado', 'registrado' => 'bg-oro-500',
            'reprobado', 'rechazado', 'cancelada', 'inactivo', 'retirado' => 'bg-red-500',
            default => 'bg-azul-700',
        };
    }
}
