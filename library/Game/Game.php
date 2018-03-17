<?php
/**
 * Created by PhpStorm.
 * User: VladKor
 * Date: 25.02.2018
 * Time: 22:08
 */

namespace Game;


class Game
{

    public $stepPlayer;

    /**
     * Конструктор.
     */
    public function __construct($stepPlayer = null)
    {
        $this->stepPlayer = $stepPlayer;
    }

    public function preStep($prePC, $prePlayer){
        switch ($prePC){
            case "Камень":
                switch ($prePlayer){
                    case "Камень":
                        return "RR";
                        break;
                    case "Ножницы":
                        return "RS";
                        break;
                    case "Бумага":
                        return "RP";
                        break;
                }
                break;
            case "Ножницы":
                switch ($prePlayer){
                    case "Камень":
                        return "SR";
                        break;
                    case "Ножницы":
                        return "SS";
                        break;
                    case "Бумага":
                        return "SP";
                        break;
                }
                break;
            case "Бумага":
                switch ($prePlayer){
                    case "Камень":
                        return "PR";
                        break;
                    case "Ножницы":
                        return "PS";
                        break;
                    case "Бумага":
                        return "PP";
                        break;
                }
                break;
        }
    }

    public function printStyle($step){
        if($this->stepPlayer == $step){
            return "border: 2px solid black;";
        }else{
            return "";
        }
    }

    public function outcomeText($who, $stepPC)
    {
        if($who == 1)
        {
            if($this->printWin($stepPC) == "1")
            {
                return "Поражение";
            }
            elseif($this->printWin($stepPC) == "0")
            {
                return "Ничья";
            }
            elseif($this->printWin($stepPC) == "-1")
            {
                return "Победа";
            }
        }
        elseif($who == 2)
        {
            if($this->printWin($stepPC) == "1")
            {
                return "Победа";
            }
            elseif($this->printWin($stepPC) == "0")
            {
                return "Ничья";
            }
            elseif($this->printWin($stepPC) == "-1")
            {
                return "Поражение";
            }
        }
    }

    public function printWin($stepPC){
        switch ($stepPC){
            case "Камень":
                switch ($this->stepPlayer){
                    case "Камень":
                        return "0";
                        break;
                    case "Бумага":
                        return "1";
                        break;
                    case "Ножницы":
                        return "-1";
                        break;
                }
                break;
            case "Бумага":
                switch ($this->stepPlayer){
                    case "Камень":
                        return "-1";
                        break;
                    case "Бумага":
                        return "0";
                        break;
                    case "Ножницы":
                        return "1";
                        break;
                }
                break;
            case "Ножницы":
                switch ($this->stepPlayer){
                    case "Камень":
                        return "1";
                        break;
                    case "Бумага":
                        return "-1";
                        break;
                    case "Ножницы":
                        return "0";
                        break;
                }
                break;
        }
    }

    public function shaping($combinations)
    {
        $motion = [$combinations[0]["rock"], $combinations[0]["paper"], $combinations[0]["scissors"]];

        for($j=0; $j<3; $j++)
        {
            for($i=0; $i<$motion[$j]; $j++)
            {
                $arrayMotion[] = $j+1;
            }
        }

        switch ($arrayMotion[array_rand($arrayMotion)])
        {
            case "1":
                return "Камень";
                break;
            case "2":
                return "Бумага";
                break;
            case "3":
                return "Ножницы";
                break;
        }
    }

    public function nameNextStep($db, $lastStep){
        switch ($lastStep[0]["PC"]){
            case "Камень":
                switch ($lastStep[0]["player"]){
                    case "Камень":
                        return $this->shaping(getArrayAction($db, "RR"));
                        break;
                    case "Ножницы":
                        return $this->shaping(getArrayAction($db, "RS"));
                        break;
                    case "Бумага":
                        return $this->shaping(getArrayAction($db, "RP"));
                        break;
                }
                break;
            case "Ножницы":
                switch ($lastStep[0]["player"]){
                    case "Камень":
                        return $this->shaping(getArrayAction($db, "SR"));
                        break;
                    case "Ножницы":
                        return $this->shaping(getArrayAction($db, "SS"));
                        break;
                    case "Бумага":
                        return $this->shaping(getArrayAction($db, "SP"));
                        break;
                }
                break;
            case "Бумага":
                switch ($lastStep[0]["player"]){
                    case "Камень":
                        return $this->shaping(getArrayAction($db, "PR"));
                        break;
                    case "Ножницы":
                        return $this->shaping(getArrayAction($db, "PS"));
                        break;
                    case "Бумага":
                        return $this->shaping(getArrayAction($db, "PP"));
                        break;
                }
                break;
        }
    }




}