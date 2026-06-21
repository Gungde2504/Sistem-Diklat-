<?php

namespace App\DTOs;

class RekapJamDTO
{
    public function __construct(
        public readonly float $jamDiklatAcara,
        public readonly float $jamDiklatMandiri,
        public readonly float $jamElearning,
    ) {
        //
    }

    public function total(): float
    {
        return round(
            $this->jamDiklatAcara + $this->jamDiklatMandiri + $this->jamElearning,
            2
        );
    }

    public function sudahMemenuhiTarget(float $target = 20): bool
    {
        return $this->total() >= $target;
    }
}