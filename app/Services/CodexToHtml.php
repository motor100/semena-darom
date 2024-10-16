<?php

namespace App\Services;

class CodexToHtml {
    
    private $templates = null;
    private $beautify = false;

    function __construct($templates, $beautify) {
        $this->templates = $templates;
        $this->beautify = $beautify;
    }

    public function render($blocks) {
        $result = [];

        foreach ($blocks as $block) {
            if (array_key_exists($block['type'], $this->beautify)) {
                $tmp = $this->beautify[$block['type']];
                $data = $block['data'];
                $result[] = call_user_func_array($tmp, $data);
            }
        }

        $html = implode($result);
        
        return $html;
    }
    
}