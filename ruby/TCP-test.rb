#!/usr/bin/ruby

require 'socket'

server = TCPServer.new 8080
loop do
	$i = 0

	client = server.accept

	STDERR.puts client.gets

	# Respond with HTTP status
	client.puts "HTTP/1.1 200 OK\r\n" +
	            "Content-Type: text/plain\r\n" +
	            "Connection: close\r\n" +
	            "Refresh: 5;url=/\r\n"

	# Print a blank line to separate the header from the response body,
	# as required by the protocol.
	client.print "\r\n"

	# Serve a fortune cookie
	client.puts `fortune -a`

	# Close the connection
	client.puts "\r\n"
	client.close
end
