<?php

error_reporting(E_ALL | E_STRICT);

define('GAME_DIR', __DIR__);

require_once GAME_DIR . DIRECTORY_SEPARATOR . 'core/Autoloader.php';
$autoloader = new Autoloader();
$autoloader->addPath(GAME_DIR . DIRECTORY_SEPARATOR . 'core');
$autoloader->register();


Game::setMazeConfigFilePath(GAME_DIR . DIRECTORY_SEPARATOR . 'gameMazeConfig.php');
Game::createMaze(new MapMazeFactory());

// start game with look for current room
Game::executeCommand('look');


readline_completion_function(function($currWord, $stringPosition) {
    return GameDictionary::getCommandsList();
});


// START GAME LOOP. 'exit' command will stop execution
while (true) {
//    $command = fgets(STDIN);
    $command = readline("> ");
    $command = trim($command);
    if ($command == 'exitgame' || $command == 'exit') {
        break;
    }

    Game::executeCommand($command);
}

exit;
