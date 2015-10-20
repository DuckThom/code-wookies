#!/bin/bash

if [ -d "$HOME/.vim" ]; then
	echo "Copying .vim folder to $PWD"
	cp -r ~/.vim "$PWD"
else
	echo "No .vim folder found in $HOME"
fi

if [ -f "$HOME/.vimrc" ]; then
	echo "Copying .vimrc file to $PWD"
	cp ~/.vimrc "$PWD"
else
	echo "No .vimrc file found in $HOME"
fi
