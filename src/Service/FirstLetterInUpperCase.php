<?php

namespace App\Service;


class FirstLetterInUpperCase {


    /**
     * global var
     *
     * @var bool
     */
    private $firstLetterInUpperCase;

    public function __construct($firstLetterInUpperCase)
    {
        $this->firstLetterInUpperCase = $firstLetterInUpperCase;
    }


    /**
     * Changes the first letter or not of the word passed in argument
     *
     * @param string $word
     * @return string
     */
    public function changeFirstLetter(string $word): string
    {
        //if the global variable firstLetterInUpperCase is true
        if ($this->firstLetterInUpperCase) {

            $wordChanged = ucfirst($word);

        //if the global variable firstLetterInUpperCase is false
        } else {

            return $word;

        }

        return $wordChanged;
    }

    /**
     * @return  bool
     */
    public function getFirstLetterInUpperCase()
    {
        return $this->firstLetterInUpperCase;
    }

    /**
     *
     * @param  bool  $firstLetterInUpperCase
     *
     * @return  self
     */
    public function setFirstLetterInUpperCase(bool $firstLetterInUpperCase)
    {
        $this->firstLetterInUpperCase = $firstLetterInUpperCase;

        return $this;
    }
}