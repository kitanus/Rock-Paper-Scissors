
<div id="eventWall">
    <div id="numberGame">Игра № <?= $lastStep[0]["id"]; ?></div>
    <div id="fieldGame">
        <form method="post" action="/">
            <div id="PC">
                <input type="text" id="stroke" name="choosePC" value="<?= $finalMotion; ?>">
                <div class="isWin"><?= $outcomeText[0]; ?></div>
            </div>
            <div id="player">
                <button class="select" style="<?= $style[0]; ?>" name="choosePlayer" value="Камень">Камень</button>
                <button class="select" style="<?= $style[1]; ?>" name="choosePlayer" value="Ножницы">Ножницы</button>
                <button class="select" style="<?= $style[2]; ?>" name="choosePlayer" value="Бумага">Бумага</button>
                <div class="isWin"><?= $outcomeText[1]; ?></div>
            </div>
        </form>
    </div>
    <div id="history">
        <table>
            <tbody align="center">
            <tr>
                <th>№</th>
                <th>Компьютер</th>
                <th>Игрок</th>
                <th>Исход</th>
            </tr>
            <?= $textTable; ?>
            </tbody>
        </table>
    </div>
</div>