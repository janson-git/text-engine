<?php

error_reporting(E_ALL | E_STRICT);

define('GAME_DIR', __DIR__);

function gameAutoloader($className)
{
    $filename = GAME_DIR . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $className . '.php';

    if (file_exists($filename) && is_readable($filename)) {
        include $filename;
    }
}

spl_autoload_register('gameAutoloader');



Game::createMaze(new MapMazeFactory());

// start game with look for current room
Game::executeCommand('look');

// START GAME LOOP. 'exit' command will stop execution
while (true) {
    $command = fgets(STDIN);
    $command = trim($command);
    if ($command == 'exitgame') {
        break;
    }

    Game::executeCommand($command);
}

exit;