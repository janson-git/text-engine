<?php

error_reporting(E_ALL | E_STRICT);

define('GAME_DIR', __DIR__);

require_once GAME_DIR . DIRECTORY_SEPARATOR . 'lib/Autoloader.php';
$autoloader = new Autoloader();
$autoloader->addPath(GAME_DIR . DIRECTORY_SEPARATOR . 'lib');
$autoloader->register();


Core\Game::setMazeConfigFilePath(GAME_DIR . DIRECTORY_SEPARATOR . 'gameMazeConfig.php');
Core\Game::createMaze(new Core\MapMazeFactory());

// start game with look for current room
Core\Game::executeCommand('look');
// game commands completion if accessible
Core\Game::tryInitCommandCompletion();

// START GAME LOOP. 'exit' command will stop execution
while (true) {
    $command = Core\Game::getCommand();
    $command = trim($command);
    if ($command == 'exitgame' || $command == 'exit') {
        break;
    }

    Core\Game::executeCommand($command);
}

exit;
