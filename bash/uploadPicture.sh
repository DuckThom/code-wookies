#!/bin/bash

############################################################
# Usage: uploadPicture.sh <filename>                       #
# 							   #
# Use with the apple terminal, this is NOT a linux script! #
############################################################

FILE="$1"
KEY="$(cat $HOME/.uploadkey)"

# Show a message asking for a file name
NAME="$(osascript -e 'Tell application "System Events" to display dialog "Enter the image name (optional):" default answer ""' -e 'text returned of result' 2>/dev/null)"

if [ -f "$FILE" ]; then
	curl -F image=@"$FILE" -F name="$NAME" -F key="$KEY" http://lunamoonfang.nl/s/upload | pbcopy
else
	echo "Usage: uploadPicture.sh <filename>"
fi

exit 0
