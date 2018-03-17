<?php
/**
 * Created by PhpStorm.
 * User: VladKor
 * Date: 18.02.2018
 * Time: 12:02
 */

    function getArrayAction($db, $where)
    {
        return $db->select(
            "`progress`",
            $db->fromArrToStr(chooseSelect("progress")),
            null,
            "`name` = '{$where}'"
        );
    }

    use Game\Game as G;

    $gameFunc = new G();

    $NumberOfMoves = count($db->select(
        "`matches`",
        $db->fromArrToStr(chooseSelect("matches"))
    ));

    $lastStep = $db->select(
        "`matches`",
        $db->fromArrToStr(chooseSelect("matches")),
        null,
        "`id` = '{$NumberOfMoves}'"
    );

    $prelastStep = $db->select(
        "`matches`",
        $db->fromArrToStr(chooseSelect("matches")),
        null,
        "`id` = '".($NumberOfMoves-1)."'"
    );

    if(!empty($lastStep)){
        $finalMotion = $gameFunc->nameNextStep($db, $lastStep);
    }

    if(!empty($_POST["choosePlayer"])){
        $game = new G($_POST["choosePlayer"], $lastStep[0]["PC"]);

        $db->insert(
            "`matches`",
            chooseInsert("matches", $_GET, $_POST, [$finalMotion, $game->printWin($finalMotion)])
        );


        $preComboStep = $gameFunc->preStep($prelastStep[0]["PC"], $prelastStep[0]["player"]);

        $preSetOfMoves = getArrayAction($db, $preComboStep);

        if(!empty($game->printWin($finalMotion)))
        {
            if($lastStep[0]["PC"] == "Камень")
            {
                $values["rock"] = $preSetOfMoves[0]["rock"]-$game->printWin($finalMotion);

                if($values["rock"] === 0){
                    $values["rock"] = "1";
                }
            }
            elseif($lastStep[0]["PC"] == "Бумага")
            {
                $values["paper"] = $preSetOfMoves[0]["paper"]-$game->printWin($finalMotion);

                if($values["paper"] === 0){
                    $values["paper"] = "1";
                }
            }
            elseif($lastStep[0]["PC"] == "Ножницы")
            {
                $values["scissors"] = $preSetOfMoves[0]["scissors"]-$game->printWin($finalMotion);

                if($values["scissors"] === 0){
                    $values["scissors"] = "1";
                }
            }
        }

        if(!empty($values)){
            $db->update(
                "`progress`",
                $values,
                "`name` = '{$preComboStep}'"
            );
        }

        $outcomeText = [$game->outcomeText(1, $finalMotion), $game->outcomeText(2, $finalMotion)];

        $style = [
            $game->printStyle("Камень"),
            $game->printStyle("Ножницы"),
            $game->printStyle("Бумага")
        ];
    }

    $steps = $db->select(
        "`matches`",
        $db->fromArrToStr(chooseSelect("matches"))
    );

    $textTable = "";
    foreach($steps AS $key => $val)
    {
        $textTable .= "<tr>";
        foreach ($val AS $keys => $value)
        {
            if($value == "1")
            {
                $textTable .= "<td>Победа</td>";
            }
            elseif($value == "0")
            {
                $textTable .= "<td>Ничья</td>";
            }
            elseif($value == "-1")
            {
                $textTable .= "<td>Поражение</td>";
            }
            else
            {
                $textTable .= "<td>" . $value . "</td>";
            }
        }
        $textTable .= "</tr>";
    }

    include APP . "/view/templates/gameBody.php";