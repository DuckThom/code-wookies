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

running = True
restart = True

HOME = os.path.expanduser("~")

cp = ConfigParser.RawConfigParser()
				
# The actual bot code
def startBot():
	global running
	global restart

	running = True
	restart = False

	cp.read(HOME + "/.lunabot/config")
	
	# Set some vaiables
	# Strings
	sNICK 		= cp.get('config', 'nickname')
	sPASS 		= cp.get('config', 'password')
	sCHAN 		= cp.get('config', 'channel')
	
	# Booleans
	bKILL 		= cp.get('config', 'enableKill')
	bINVALIDOUTPUT  = cp.get('config', 'invalidOutput')
	
	# Lists
	lCOMMANDS 	= ast.literal_eval(cp.get('config', 'commands'))
	lADMINS 	= ast.literal_eval(cp.get('config', 'admins'))

	# Dictionary
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
	while running:
		# Read the input from the socket
		read_line = s.recv(1024)
		message = ''		
		output = 1		

		# This will match if someone tries to execute a command
		if (re.search(sCHAN + " :!", read_line)):
			command = read_line.split(sCHAN + " :!", 1)[1].replace("\r\n", "")	
			user 	= read_line.split("!~", 1)[0].replace(":", "")			

			print "User ", user, " issued command: ", command

			message = user + ": "

			if command in lCOMMANDS:
		
				if command == "kill" and user in lADMINS and bKILL == "1":
					running = False # Stop the infinite loop
				elif command == "reload" and user in lADMINS:
					restart = True
					running = False
					print "Restarting..."

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

		# try to the the title of the url
		else:
			try:
				chat_message = read_line.split(sCHAN + " :", 1)[1].replace("\r\n", "")

				if re.match("http", chat_message):
					url     = chat_message.split(" ", 1)[0]
					message += read_line.split("!~", 1)[0].replace(":", "") + ": "
					message += BeautifulSoup(urllib.urlopen(url)).title.string
			
			except Exception:
				pass		

		print read_line
		
		if message != "" and output == 1:
			s.send("PRIVMSG " + sCHAN + " :" + message + "\n")

	# END WHILE

	print "Bot stopped :("

	# Disconnect from the IRC server
	s.send("QUIT :Going back to the moon! \n")

	time.sleep(1)
# END DEF 

def userInput():
	global running

	print "User input enabled!"

	while running:
		raw_cmd = raw_input()
		s.send(raw_cmd + "\n")

		if re.match("QUIT", raw_cmd):
			running = False
	# END WHILE
# END DEF

def createConfig():
	cp.add_section('config')
	cp.set('config', 'nickname', 'The name the bot should use')
	cp.set('config', 'password', 'Password to identify with NickServ')
	cp.set('config', 'channel', 'The channel to connect to')
	cp.set('config', 'enableKill', 'Allow the bot to be killed with !kill from chat ; 0 or 1')
	cp.set('config', 'invalidOutput', 'Enable command not found response ; 0 or 1')
	cp.set('config', 'commands', 'Enter the command names here ; ex: ["command1", "command2"]')
	cp.set('config', 'admins', 'Enter the names of the admins ; ex: ["admin1", "admin2"]')

	cp.add_section('commandTypes')
	cp.set('commandTypes', 'command name', 'Command type ; text, system, silent')
	cp.set('commandTypes', 'kill', 'silent')

	cp.add_section('messages')
	cp.set('messages', 'command1', 'This is an example message ; Message is optional for system type commands')

	cp.add_section('systemCommands')
	cp.set('systemCommands', 'command2', 'System command ; ex: ls or mkdir')

	if not os.path.exists(HOME + "/.lunabot/"):
		os.mkdir(HOME + "/.lunabot")

	# Writing our configuration file to 'example.cfg'
	with open(HOME + '/.lunabot/config', 'w+b') as configfile:
		cp.write(configfile)

	configfile.close()

	print "Config file generated, closing bot. Please edit the config file located in ~/.lunabot"
# END DEF

try:
	if not os.path.exists(HOME + "/.lunabot/config"):
		print "Config file not found, creating..."
		createConfig()
		exit()
	
	while restart:
		s = socket.create_connection(("irc.freenode.net", 6667))
	
		bot = threading.Thread(target=startBot)
		userInput = threading.Thread(target=userInput)	

		bot.daemon = True
		userInput.daemon = True
		
		bot.start()

		# While the bot is running, wait here...
		bot.join()
	
		# Close the connection	
		s.close()
	# END WHILE
	sys.exit()

	print "Connection closed"
except KeyboardInterrupt:
	print "CTRL-C found, exiting..."
	
	if bot.isAlive:
		s.send("QUIT :Oh noes! Someone killed my script! \n")
		time.sleep(1)
		s.close()
	
	sys.exit()
