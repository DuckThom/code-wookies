#!/usr/bin/env python

import sys
import os
import time
import re
import socket
import ConfigParser

HOME = os.path.expanduser("~")

cp = ConfigParser.RawConfigParser()
cp.read(HOME + "/.lunabot/config")

sNICK = cp.get('config', 'nickname')
sPASS = cp.get('config', 'password')
sCHAN = cp.get('config', 'channel')
bKILL = cp.get('config', 'enableKill')

commands = ("greet", "kill", "time")
initial_response = connected_response = identify_response = read_line = ""

# Set the server stuff
s = socket.create_connection(("irc.freenode.net", 6667))

print "Connecting..."

while not "Ident response" in initial_response:
	initial_response = s.recv(1024)

# Set the bot name
s.send("NICK " + sNICK + "\n")
s.send("USER " + sNICK + " 8 * : " + sNICK + "\n")

while not "MODE " + sNICK in connected_response:
	connected_response = s.recv(1024)

print "Connected!"

# Wait for the connection to settle
time.sleep(1)

print "Identifying..."

s.send("PRIVMSG NickServ :IDENTIFY " + sPASS + "\n")

while not "now identified" in identify_response:
	identify_response = s.recv(1024)
	print identify_response

print "Identified!"

time.sleep(1)

print "Joining channel..."

# Join the channel 
s.send("JOIN " + sCHAN + "\n")

print "Joined channel " + sCHAN + "!"

# Fruity Loops!
while True:
	# Read the input from the socket
	read_line = s.recv(1024)

	# This will match if someone tries to execute a command
	if (re.search(sCHAN + " :!", read_line)):
		command = read_line.split(sCHAN + " :!", 1)[1].replace("\r\n", "")	
			
		print "Command: ", command

		if command in commands:
			if command == "greet":
				message = "Hi, I'm " + sNICK + ", nice to meet you! :)"
			elif command == "time":
				message = "My brand new Banana Watch says it's " + os.popen("date").read()
			elif command == "kill" and bKILL == "1":
				break # Stop the infinite loop
			elif command == "kill" and bKILL == "0":
				message = "Kill command disabled"
		else:
			message = "Sorry, that's an invalid command"

		if message != "":
			s.send("PRIVMSG " + sCHAN + " :" + message + "\n")
		
		message = ''
	# This will respond to PINGs
	elif (re.match('PING', read_line)):
		server = read_line.split(":", 1)[1]
		s.send("PONG :" + server)
		print "PONG ", server
	
	# This will just print the chat
	else:
		print read_line

print "Valid kill command issued, goodbye cruel world! ;_;"

# Disconnect from the IRC server
s.send("QUIT :Going back to the moon! \n")

# Close the socket
s.close()

print("Closed socket! Bye Bye o/ ")

# Terminate the script
exit()
