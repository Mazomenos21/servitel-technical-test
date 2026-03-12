<?php

use App\Mcp\Servers\AppServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/app', AppServer::class);
