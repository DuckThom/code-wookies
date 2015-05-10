#!/usr/bin/env python

import sys
import os
import time
import re
import socket
import ConfigParser
import ast
import urllib
import threading
from bs4 import BeautifulSoup

HOME = os.path.expanduser("~")

cp = ConfigParser.RawConfigParser()
cp.read(HOME + "/.lunabot/config")

# The actual bot code
def startBot():
	
	# Set some vaiables
	sNICK 		= cp.get('config', 'nickname')
	sPASS 		= cp.get('config', 'password')
	sCHAN 		= cp.get('config', 'channel')
	bKILL 		= cp.get('config', 'enableKill')
	bINVALIDOUTPUT  = cp.get('config', 'invalidOutput')
	lCOMMANDS 	= ast.literal_eval(cp.get('config', 'commands'))
	dCOMMANDTYPES   = dict(cp.items("commandTypes"))
	dMESSAGES	= dict(cp.items("messages"))
	dSYSTEMCOMMANDS = dict(cp.items("systemCommands"))
	initial_response= connected_response = identify_response = read_line = ""

	# Set the server stuff
	print "Connecting..."

	# Wait for initial server response
	while not "Ident response" in initial_response:
		initial_response = s.recv(1024)

	# Set the bot name
	s.send("NICK " + sNICK + "\n")
	s.send("USER " + sNICK + " 8 * : " + sNICK + "\n")

	# Wait for the connection to be made
	while not "MODE " + sNICK in connected_response:
		connected_response = s.recv(1024)

	print "Connected!"

	# Wait for the connection to settle
	time.sleep(1)

	print "Identifying..."

	s.send("PRIVMSG NickServ :IDENTIFY " + sPASS + "\n")

	# Wait for NickServ identification
	while not "now identified" in identify_response:
		identify_response = s.recv(1024)

	print "Identified!"

	time.sleep(1)

	print "Joining channel..."

	# Join the channel 
	s.send("JOIN " + sCHAN + "\n")

	print "Joined channel " + sCHAN + "!"

	userInput.start()

	# Loop through the input handling
	while True:
		# Read the input from the socket
		read_line = s.recv(1024)
		message = ''		

		# This will match if someone tries to execute a command
		if (re.search(sCHAN + " :!", read_line)):
			command = read_line.split(sCHAN + " :!", 1)[1].replace("\r\n", "")	
			user 	= read_line.split("!~", 1)[0].replace(":", "")			

			print "User ", user, " issued command: ", command

			output 	= 1
			message = user + ": "

			if command in lCOMMANDS:
		
				if command == "kill" and user == "Luna_Moonfang" and bKILL == "1":
					break # Stop the infinite loop
				
				if dCOMMANDTYPES[command] == "silent":
					output = 0
				elif dCOMMANDTYPES[command] == "system":
					if command in dMESSAGES:
						message += dMESSAGES[command] + " "
			
					message += os.popen(dSYSTEMCOMMANDS[command]).read()
				elif dCOMMANDTYPES[command] == "text":
					message += dMESSAGES[command]
				

			else:
				if bINVALIDOUTPUT == "1":
					message += "Sorry, that's an invalid command"
				else:
					output = 0


		# This will respond to PINGs
		elif (re.match('PING', read_line)):
			server = read_line.split(":", 1)[1]
			s.send("PONG :" + server)
			print "PONG ", server

		# This will just print the chat
		else:
			try:
				chat_message = read_line.split(sCHAN + " :", 1)[1].replace("\r\n", "")

				if re.match("http", chat_message):
					url = chat_message.split(" ", 1)[0]
					message = BeautifulSoup(urllib.urlopen(url)).title.string
			except Exception:
				pass		

		print read_line
		
		if message != "" and output == 1:
			s.send("PRIVMSG " + sCHAN + " :" + message + "\n")

	# END WHILE

	print "Valid kill command issued, goodbye cruel world! ;_;"

	# Disconnect from the IRC server
	s.send("QUIT :Going back to the moon! \n")

	# Close the connection
	s.close()

	print("Closed socket! Bye Bye o/ ")
# END DEF 

def userInput():
	print "User input enabled!"

	while True:
		input = raw_input()
		s.send(input + "\n")

try:
	s = socket.create_connection(("irc.freenode.net", 6667))
	
	bot = threading.Thread(target=startBot)
	userInput = threading.Thread(target=userInput)	

	bot.daemon = userInput.daemon = True
		
	bot.start()

	# While the bot is running, wait here...
	while bot.isAlive: bot.join(5)	
except KeyboardInterrupt:
	print "CTRL-C found, exiting..."
	s.send("QUIT :Oh noes! Someone killed my script! \n")
	s.close()
