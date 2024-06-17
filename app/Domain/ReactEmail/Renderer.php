<?php

namespace App\Domain\ReactEmail;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class Renderer extends Process
{
    private function __construct(string $view, array $data = [])
    {
        parent::__construct([
            $this->resolveNodeExecutable(),
            base_path('/node_modules/.bin/tsx'),
            __DIR__ . '/render.tsx',
            base_path('/emails/') . $view,
            json_encode($data)
        ], base_path());
    }

    public static function render(string $view, array $data): array
    {
        $process = new self($view, $data);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return json_decode($process->getOutput(), true);
    }

    public static function resolveNodeExecutable(): string
    {
        return app(ExecutableFinder::class)->find('node');
    }
}
