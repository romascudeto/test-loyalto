<?php

$n = 3;
$m = 4;
$done = false;
$isFirst = true;
$players = [];
$evalute = [];
while (!$done) {
    if ($isFirst) {
        generateDice($n, $m, $players);
        $isFirst = false;
    } else {
        generateDiceNext($players);
    }
    echo "\nGenerate Dice : \n";
    echo (json_encode($players));
    echo "\nEvaluate Game : \n";
    $done = evaluateGame($players);
    echo (json_encode($players));
    echo "\n\n";
}

// choose the winner
$winner = chooseWinner($players);
echo "The Winner is : " . $winner . "\n";

function generateDice($n, $m, &$players)
{
    for ($i = 0; $i < $n; $i++) {
        $players['player_' . $i] = [
            "score" => 0,
            "dice" => []
        ];
        for ($j = 0; $j < $m; $j++) {
            $players['player_' . $i]['dice'][] = rand(1, 6);
        }
    }
}

function generateDiceNext(&$players)
{
    for ($i = 0; $i < count($players); $i++) {
        $tempCount = count($players['player_' . $i]['dice']);
        $players['player_' . $i]['dice'] = [];
        for ($j = 0; $j < $tempCount; $j++) {
            $players['player_' . $i]['dice'][] = rand(1, 6);
        }
    }
}

function evaluateGame(&$players)
{
    // Loop for check dice number 1 or 6
    for ($i = 0; $i < count($players); $i++) {
        // Init to counter dice number 1
        $players['player_' . $i]['count_1'] = 0;
        for ($j = 0; $j < count($players['player_' . $i]['dice']); $j++) {
            // Check if dice number is 6 then add to score
            if ($players['player_' . $i]['dice'][$j] == 6) {
                array_splice($players['player_' . $i]['dice'], $j, 1);
                $players['player_' . $i]['score'] += 6;
                $j--;
            }
            // Check if dice number is 1 then add count_1 for next purpose
            else if ($players['player_' . $i]['dice'][$j] == 1) {
                array_splice($players['player_' . $i]['dice'], $j, 1);
                $players['player_' . $i]['count_1'] += 1;
                $j--;
            }
        }
    }

    // Loop for add dice number 1 to next player 1 to 2, 2 to 3, ... n to 1
    for ($i = 0; $i < count($players); $i++) {
        $nextPlayer = $i + 1;

        // check if the next player is not at the end of array
        if ($nextPlayer  < count($players)) {

            // Loop for get next player who still playing
            for ($count = $nextPlayer; $count < count($players); $count++) {
                if (count($players['player_' . $count]['dice']) > 0) {
                    $nextPlayer = $count;
                    break;
                }
            }
            for ($j = 0; $j < $players['player_' . $i]['count_1']; $j++) {
                array_push($players['player_' . $nextPlayer]['dice'], 1);
            }
        } else {
            for ($j = 0; $j < $players['player_' . $i]['count_1']; $j++) {
                array_push($players['player_0']['dice'], 1);
            }
        }
        unset($players['player_' . $i]['count_1']);
    }

    // Check if end game
    $countEndPlayer = 0;
    for ($i = 0; $i < count($players); $i++) {
        if (count($players['player_' . $i]['dice']) == 0) {
            $countEndPlayer++;
        }
    }
    // IF player remain 1 then end the game
    if ($countEndPlayer == count($players) - 1) {
        return true;
    }
    return false;
}

function chooseWinner($players)
{

    // get the highest point 
    $highestScore = max(array_column($players, 'score'));
    $winnerString = '';
    foreach ($players as $key => $player) {
        if ($player['score'] == $highestScore) {
            $winnerString = $winnerString . " " . $key;
        }
    }
    return $winnerString . "  with " . $highestScore . " points";
}
