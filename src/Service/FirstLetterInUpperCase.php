<?php

namespace App\Service;


class FirstLetterInUpperCase {


    /**
     * var globale pour passer en miniscule
     *
     * @var bool
     */
    private $firstLetterInUpperCase;

    public function __construct($firstLetterInUpperCase)
    {
        $this->firstLetterInUpperCase = $firstLetterInUpperCase;
    }


    public function changeFirstLetter(string $word)
    {
        if ($this->firstLetterInUpperCase) {

            $wordChanged = ucfirst($word);

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