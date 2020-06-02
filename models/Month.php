<?php 

class Month {

    private $monthName;
    private $year;

    public function __construct(int $monthNum, int $year) {
        $this->setMonthName($monthNum);
        $this->year = $year;
    }

    public function getMonthName(): string {
        return $this->monthName;
    }

    public function setMonthName(int $num) {
        $fr_names = [1 => "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
        $this->monthName = $fr_names[$num];
    }

    public function getYear(): int {
        return $this->year;
    }

    public function setYear(int $year) {
        $this->year = $year;
    }

}