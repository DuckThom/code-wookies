#!/bin/bash

# Get my userid from the config file
USERID=$(cat /etc/telegram-cli/userid)

# Echo the current date/time to the screen
echo "V----------[$(date)]----------V"
echo "Checking Minecraft Server status..."

# Check if there is a screen with the name minecraft
if screen -list | grep -q "minecraft"; then
	# The server is still running :D
	echo "Server is running"
else
	# Woops, something went wrong... :(
	# Better warn the user about it!
	echo "ERROR: Server is not running!"
	echo "Restarting server..."

	# Change the active directory to the MC server location
	cd /home/luna/Downloads/mc1.8.3/

	# Send a notification to myself via Telegram
	echo "msg $USERID \"Minecraft Server crash/shutdown! \nRestarting server at $(date)\"" | netcat localhost 1337

	# Log this event in a logfile
	echo "Oops! It looks like the server has crashed around [$(date)]." >> server_watchdog.log
	echo "Trying to restart the server..." >> server_watchdog.log
	echo "------------------------------------------------------------" >> server_watchdog.log

	# Create a screen session with the name minecraft
	screen -dmS minecraft java -Xmx2G -Xms2G -jar minecraft_server.1.8.3.jar
fi

# Check again in 30 seconds
sleep 30

# Restart this script
exec bash /home/luna/Git\ Repositories/code-wookies/bash/checkMinecraftServer.sh
