#!/bin/bash

# Usage: uploadPicture.sh <filename>

FILE="$1"
NAME="$(osascript -e 'Tell application "System Events" to display dialog "Enter the image name:" default answer ""' -e 'text returned of result' 2>/dev/null)"

if [ $FILE != "" ]; then
	curl -F image=@"$FILE" -F name="$NAME" -F key="$UPLOAD_KEY" http://lunamoonfang.nl/s/upload | pbcopy
else
	echo "Usage: uploadPicture.sh <filename>"
fi

exit 0
