#!/bin/bash

if [ -d ".vim" ]; then
	echo "Copying .vim folder to $HOME"
	cp -r .vim "$HOME"
else
	echo "No .vim config folder found in $PWD"
fi

if [ -f ".vimrc" ]; then
	echo "Copying .vimrc file to $HOME"
	cp .vimrc "$HOME"
else
	echo "No .vimrc config file found in $PWD"
fi
