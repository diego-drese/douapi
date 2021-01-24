<?php

namespace Oka6\Admin\Interfaces;

interface Oka6Interface {

    /** Methodo que retorna as rules para validação
     * @param array $params
     */
    public function getRulesValidation(array $params);

    /** Methodo que retorna as mensagens das rules
     * @param array $params
     */
    public function getRulesValidationMessage(array $params);
}

