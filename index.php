<?php

error_reporting(E_ALL | E_STRICT);

define('GAME_DIR', __DIR__);

require_once GAME_DIR . DIRECTORY_SEPARATOR . 'lib/Autoloader.php';
$autoloader = new Autoloader();
$autoloader->addPath(GAME_DIR . DIRECTORY_SEPARATOR . 'lib');
$autoloader->register();


use Core\Game;

Game::setMazeConfigFilePath(GAME_DIR . DIRECTORY_SEPARATOR . 'gameMazeConfig.php');
Game::createMaze(new Core\MapMazeFactory());

// start game with look for current room
Game::executeCommand('look');
// game commands completion if accessible
Game::tryInitCommandCompletion();

// START GAME LOOP. 'exit' command will stop execution
while (true) {
    $command = Game::readCommand();
    $command = trim($command);
    if ($command == 'exitgame' || $command == 'exit') {
        break;
    }

    Game::executeCommand($command);
}

exit;
