#!/bin/bash
# Wrapper script to run boost:mcp with localhost database connection
# This allows MCP to connect to the database from the host machine
export DB_HOST=127.0.0.1
export DB_PORT=5432
export DB_DATABASE=servitel-db
export DB_USERNAME=root
export DB_PASSWORD=password

exec php artisan boost:mcp "$@"
