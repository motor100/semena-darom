<?php

namespace App\Services;

class SingleProduct
{
    protected $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Заголовок в 2 цвета
     * @return string
     */
    public function double_color_title(): string
    {
        // Строка в массив слов
        $words_array = explode(" ", $this->title);

        if (count($words_array) > 1) { // Если количество слов в заголовке > 1, то добавляю span к первому слову
            $first_word = "<span class=\"grey-text\">" . $words_array[0] . "</span>";
            $words_array[0] = $first_word;
            return implode(" ", $words_array);
        } else { // Иначе добавляю span ко всему заголовку
            return "<span class=\"grey-text\">" . $this->title . "</span>";
        }
    }
}