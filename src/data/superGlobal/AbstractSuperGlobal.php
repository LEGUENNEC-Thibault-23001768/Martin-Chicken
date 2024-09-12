<?php

namespace data\superGlobal;

use Exception;

abstract class AbstractSuperGlobal
{
    protected function sanitize(&...$variables) {
        foreach ($variables as &$variable) {
            $variable = trim($variable);
            $variable = htmlspecialchars($variable);
            return;
        }
    }
}