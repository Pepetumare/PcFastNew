<?php

namespace App\Services;

use App\Models\MonitoredPc;

class RecommendationService
{
    public function generateForPc(MonitoredPc $pc): array
    {
        $specs = $pc->hardwareSpec;
        if (!$specs) {
            return ['Esperando recibir las especificaciones del hardware.'];
        }
        $recommendations = [];
        // Regla 1: Disco Duro
        foreach ($specs->disks as $disk) {
            if (str_contains(strtoupper($disk['type']), 'HDD')) {
                $recommendations[] = "**Mejora de Almacenamiento:** Tu equipo usa un disco mecánico (HDD). Cambiarlo por una Unidad de Estado Sólido (SSD) es la mejora que más acelerará el encendido y la apertura de programas.";
                break;
            }
        }
        // Regla 2: Memoria RAM
        if ($specs->ram_total_gb < 8) {
            $recommendations[] = "**Ampliación de RAM:** Con {$specs->ram_total_gb}GB de RAM, tu equipo puede tener dificultades con varias tareas a la vez. Considera ampliarla a 16GB para una multitarea más fluida.";
        }
        if (empty($recommendations)) {
            $recommendations[] = "Tu equipo tiene una configuración de hardware equilibrada para tareas cotidianas.";
        }
        return $recommendations;
    }
}
