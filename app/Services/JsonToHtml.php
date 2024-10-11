<?php

namespace App\Services;

class JsonToHtml {
    
    protected $json_string;

    public function __construct($json_string) {
        $this->json_string = $json_string;
    }

    public function render(): string
    {
        // Валидация
        $configuration_array = [
            "tools" => [
                "paragraph" => [
                    "text" => [
                        "type" => "string",
                        "allowedTags" => "i,b,a[href]"
                    ]
                ],
                "header" => [
                    "text" => [
                        "type" => "string",
                        "required" => false
                    ],
                    "level" => [
                        "type" => "int",
                        "canBeOnly" => [2, 3, 4]
                    ]
                ],
                "list" => [
                    "style" => [
                        "type" => "string",
                        "canBeOnly" => ["ordered", "unordered"]
                    ],
                    "items" => [
                        "type" => "array",
                        "data" => [
                            "-" => [
                                "type" => "string",
                                "allowedTags" => "i,b"
                            ]
                        ]
                    ]
                ],
                "table" => [
                    "withHeadings" => [
                        "type" => "bool",
                        "required" => false
                    ],
                    "content" => [
                        "type" => "array",
                        "data" => [
                            "-" => [
                                "type" => "array",
                                "data" => [
                                    "-" => [
                                        "type" => "string"
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "image" => [
                    "caption" => [
                        "type" => "string",
                        "required" => false
                    ],
                    "stretched" => [
                        "type" => "bool",
                        "required" => false
                    ],
                    "withBackground" => [
                        "type" => "bool",
                        "required" => false
                    ],
                    "withBorder" => [
                        "type" => "bool",
                        "required" => false
                    ],
                    "file" => [
                        "type" => "object",
                        "data" => [
                            "url" => [
                                "type" => "string",
                            ]
                        ]
                    ],
                    
                    
                ],
                "attaches" => [
                    "title" => [
                        "type" => "string",
                        "required" => false
                    ],
                    "file" => [
                        "type" => "object",
                        "data" => [
                            "url" => [
                                "type" => "string",
                            ]
                        ]
                    ],
                ]
            ]
        ];

        /**
         * Добавить в файл /vendor/codex-team/editr.js/editorjs/BlockHandler.php после строки 168
         * case 'object':
         * $this->validate($rule['data'], $value);
         * break;
         */
        
        $configuration = json_encode($configuration_array);

        try {
            // Initialize Editor backend and validate structure
            $editor = new \EditorJS\EditorJS( $this->json_string, $configuration );
             
            // Get sanitized blocks (according to the rules from configuration)
            $blocks = $editor->getBlocks();
             
        } catch (\EditorJS\EditorJSException $e) {
            // process exception
            $blocks = "Error " . $e;
        }

        // Параметры конвертации в html
        $html_param = [
            'paragraph' => function($text) {
                return "<p class='p'>{$text}</p>";
            },
            'header' => function($text, $level) {
                return "<h{$level}>{$text}</h{$level}>";
            },
            'list' => function($items, $style) {
                $list_items = "";
                foreach($items as $item) {
                    $list_items .= "<li class='list-item'>" . $item . '</li>';
                }
                return $style == "ordered" ? "<ol class='list'>" . $list_items . "</ol>" : "<ul class='list'>" . $list_items . "</ul>";
            },
            'table' => function($content, $withHeadings) {
                $tr = "";
                foreach($content as $row => $value) {
                    $tr .= "<tr>";
                    foreach($value as $td) {
                        $tr .= ($row == 0 && $withHeadings ? "<th>" . $td . "</th>" : "<td>" . $td . "</td>");
                    }
                    $tr .= "</tr>";
                }
                return "<table class='table'>" . $tr . "</table>";
            },
            'image' => function($file, $caption, $withBorder, $stretched, $withBackground) {
                return "<img src=\"{$file['url']}\" title=\"{$caption}\" alt=\"{$caption}\">";
            },
            'attaches' => function($file, $title) {
                return "<a href=\"{$file['url']}\" target=\"_blank\">{$title}</a>";
            },
            
        ];

        $codex = new \App\Services\CodexToHtml($templates = null, $html_param);

        return $codex->render($blocks);
    }
    
}