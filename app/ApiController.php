<?php

namespace App;

use JsonException;

abstract class ApiController
{
    protected array $params = [];
    protected ?array $jsonInput = null;

    public function __invoke(string ...$params): void
    {
        $this->params = $params;

        header('Content-type: application/json');

        if (!$this->validateExists()) {
            http_response_code(404);
            return;
        }

        try {
            $this->setJsonInput();
        } catch (JsonException) {
            http_response_code(400);
            return;
        }

        if (!is_null($error = $this->validate())) {
            http_response_code(422);
            echo json_encode(['error' => $error]);
            return;
        }

        if (!is_null($result = $this->handle())) {
            echo json_encode($result);
        }
    }

    protected function validate(): ?string {
        return null;
    }

    protected function validateExists(): bool {
        return true;
    }

    protected abstract function handle(): mixed;

    private function setJsonInput(): void
    {
        if ($input = file_get_contents('php://input')) {
            $this->jsonInput = json_decode(
                $input,
                true,
                flags: JSON_THROW_ON_ERROR
            );
        }
    }
}
