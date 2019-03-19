<?php

session_start();

if (isset($_GET['module']) && $_GET['module'] === 'games' && $_GET['page'] === 'game1over'):
    if (isset($_POST['restart'])):
        $_SESSION['userHP'] = $_SESSION['systemHP'] = 10;
        header("location: index.php?page=game1");
    endif;
    if ($_SESSION['userHP'] <= 0):
        echo "You are lost =(";
    elseif ($_SESSION['systemHP'] <= 0):
        echo "Congratulates! You are win!";
    endif;
    ?>
    <form action="" method="post">
        <input type="submit" name="restart" value="Restart">
    </form>
    <?php
endif;

if ($_GET['page'] === "game1"):


if (!isset($_SESSION['userHP']) || !isset($_SESSION['systemHP']))
{
    $_SESSION['userHP'] = $_SESSION['systemHP'] = 10;
}
$errors = [];
$systemNumber = rand(1, 3);
$damage = rand(1, 4);
$damageTakenBy = "";
if (isset($_POST['userNumber'])):
    $userNumber = stripslashes($_POST['userNumber']);
    if ($userNumber >= 1 && $userNumber <= 3):
        if ((integer)$userNumber === $systemNumber):
            $_SESSION['userHP'] -= $damage;
            $damageTakenBy = "user";
        else:
            $_SESSION['systemHP'] -= $damage;
            $damageTakenBy = "system";
        endif;
    else:
        $errors[] = "You entered the wrong number. Please, enter a number from 1 to 3";
    endif;
endif;
?>

<div style="width: 800px; margin: 0 auto;">
    <div style="float: left;">
        <span>(<?= $_SESSION['userHP'] ?> HP)</span>
        <progress max="10" value="<?= $_SESSION['userHP'] ?>"></progress>
        <span>Вы</span>
        <?php
        if ($damageTakenBy === "user"):
        ?>
        <span style="color: red;">(-<?= $damage ?>)</span>
        <?php
        endif;
        ?>
    </div>
    <div style="float: right">
        <span>Противник</span>
        <?php
        if ($damageTakenBy === "system"):
        ?>
        <span style="color: red;">(-<?= $damage ?>)</span>
        <?php
        endif;
        ?>
        <progress max="10" value="<?= $_SESSION['systemHP'] ?>"></progress>
        <span>(<?= $_SESSION['systemHP'] ?> HP)</span>
    </div>
    <div style="clear: both;"></div>
    <form action="" method="post" style="position: relative; top: 10em; text-align: center;">
        <?php
        foreach ($errors as $error):
            echo "<p style='color: red; white-space: nowrap;'>";
            echo $error;
            echo "</p>";
        endforeach;
        ?>
        <span style="white-space: nowrap;">Enter a number from 1 to 3</span>
        <input type="text" id="number" name="userNumber">
        <input type="submit" value="Hit">
    </form>
</div>

<?php
if ($_SESSION['userHP'] <= 0 || $_SESSION['systemHP'] <= 0)
{
    header("location: index.php?module=games&page=game1over");
}
endif;
?>