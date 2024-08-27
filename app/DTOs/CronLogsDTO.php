<?php

namespace App\DTOs;

class CronLogsDTO
{
    public function __construct(
        private \DateTime $lastRun,
        private float $executionTime,
        private string $usageMemory
    )
    {
        $this->lastRun = $lastRun;
        $this->executionTime = $executionTime;
        $this->usageMemory = $usageMemory;
    }

    public function getLastRun(): \DateTime
    {
        return $this->lastRun;
    }

    public function getExecutionTime(): float
    {
        return number_format($this->executionTime, 2);
    }

    public function getUsageMemory(): string
    {
        return $this->usageMemory;
    }

}
