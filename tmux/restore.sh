#!/bin/bash

if [ -d ".tmux" ]; then
	echo "Copying .tmux config folder to $HOME"
	cp -r .tmux "$HOME"
else
	echo "No .tmux config folder found in $PWD"
fi

if [ -f ".tmux.conf" ]; then
	echo "Copying .tmux.conf file to $HOME"
	cp .tmux.conf "$HOME"
else
	echo "No .tmux.conf config file found in $PWD"
fi
