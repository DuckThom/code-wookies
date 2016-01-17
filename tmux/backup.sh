#!/bin/bash

if [ -d "$HOME/.tmux" ]; then
	echo "Copying .tmux folder to $PWD"
	cp -r ~/.tmux "$PWD"
else
	echo "No .tmux folder found in $HOME"
fi

if [ -f "$HOME/.tmux.conf" ]; then
	echo "Copying .tmux.conf file to $PWD"
	cp ~/.tmux.conf "$PWD"
else
	echo "No .tmux.conf file found in $HOME"
fi
