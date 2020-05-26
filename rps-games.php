<?php

const ROCK = 1;
const SCISSORS = 2;
const PAPER = 3;

const HAND_TYPE = array(
    ROCK => 'グー',
    SCISSORS => 'チョキ',
    PAPER => 'パー'
);

const DRAW = 0;
const LOSE = 1;
const WIN = 2;

const RESULT = array(
    DRAW => 'あいこ',
    LOSE => 'あなたの負け',
    WIN => 'あなたの勝ち'
);

const JUDGEKEY = 3;

const NEXTGAME = array(
    'YES',
    'NO'
);

// プレイヤーの手を入力する関数
function inputPlayerHand() {
    $num = trim(fgets(STDIN));
    if (validatePlayer($num) === false) {
        return inputPlayerHand();
    }
    return $num;
}

// COMの手がランダムに入力される関数
function getComHand() {
    $num = mt_rand(ROCK, PAPER);
    return $num;
}

// プレイヤーが入力した手に対するバリデーション関数
function validatePlayer($check) {
    if (empty($check)) {
        echo '値が空です';
        echo PHP_EOL;
        return false;
    }
    if (!array_key_exists($check,HAND_TYPE)) {
        echo '値は対象の数字【1:グー,2:チョキ,3:パー】にしてください';
        echo PHP_EOL;
        return false;
    }
    return true;
}

// ゲームを続行するかを確認する関数
function nextGame() {
    echo 'もう一度遊ぶ？('.NEXTGAME[0].'または'.NEXTGAME[1].'を入力してください)';
    echo PHP_EOL;

    $check = trim(fgets(STDIN));

    if (validateNextGame($check) === false) {
        return nextGame();
    }

    if ($check === NEXTGAME[0]) {
        return true;
    } elseif ($check === NEXTGAME[1]) {
        return false;
    }
}

// ゲームを続行するかプレイヤーが入力した内容に対するバリデーション関数
function validateNextGame($check) {
    if (empty($check)) {
        echo '値が空です';
        echo PHP_EOL;
        return false;
    }
    if ($check !== NEXTGAME[0] && $check !== NEXTGAME[1]) {
        echo  NEXTGAME[0].'または'.NEXTGAME[1].'を入力してください';
        echo PHP_EOL;
        return false;
    }
    return true;  
}

// じゃんけんの勝ち負けの判定と勝敗を返す関数
function judge($player,$com) {
    echo 'PLAYER【'.HAND_TYPE[$player].'】| COM【'.HAND_TYPE[$com].'】';
    echo PHP_EOL;
    
    $result = ($player - $com + JUDGEKEY) % JUDGEKEY;
    return $result;
}

// じゃんけんの勝敗を示す関数
function show($result) {
    // 上の定数で宣言した各勝敗判定の数字と、$result内の数字を合わせて結果を出す
    switch (true) {
        case $result === DRAW: //DRAWに0が代入
            echo RESULT[DRAW];
            break;
        case $result === LOSE: //LOSEに1が代入
            echo RESULT[LOSE];
            break;
        case $result === WIN: //WINに2が代入
            echo RESULT[WIN];
            break;
    }
}

//じゃんけん実行
function main() {
    echo 'じゃんけん！...(数字を入力【1:グー,2:チョキ,3:パー】)';
    echo PHP_EOL;

    $player = inputPlayerHand();
    $com = getComHand();
    $result = judge($player,$com);
    show($result);

    //$result があいこだったらmain関数を再帰処理
    if ($result === RESULT[DRAW]) {
        return main();
    }

    //もしゲーム続行ならmain関数を再帰処理
    $isContinue = nextGame();
    if ($isContinue) {
        return main();
    }
    //終了
}
main();