<?php

declare(strict_types=1);

namespace O0h\IyaaaaaNaCodeExample\Controller;

abstract class Controller
{
    /** @var array<string, mixed> */
    private array $viewVars = [];

    public function initialize(): self
    {
        if ($_GET['debug_user_id'] ?? false) {
            $_SESSION['user_id'] = $_GET['debug_user_id'];
        }

        return $this;
    }

    protected function set($data): void
    {
        $this->viewVars = array_merge($this->viewVars, $data);
    }

    protected function render(string $templateName): void
    {
        $contentBody = (function ($templateName, $viewVars) {
            $templatePath = PJ_ROOT . '/templates/' . $templateName;
            extract($viewVars);
            ob_start();

            require $templatePath;
            $contents = ob_get_contents();
            ob_end_clean();

            return $contents;
        })($templateName, $this->viewVars);

        echo $contentBody;
    }
}
