// Console API endpoints
$router->get("/servers/{id}/console/validate", function ($params) use ($app, $container) {
    $serverModel = $container->make(\App\Models\Server::class);
    $server = $serverModel->findById($params["id"]);
    
    if (!$server) {
        http_response_code(404);
        echo json_encode(["error" => "Server not found"]);
        exit;
    }
    
    // Check access
    $userId = $app->session()->get("user_id");
    $role = $app->session()->get("role");
    
    if ($role !== "owner" && $role !== "admin" && $server["user_id"] != $userId) {
        http_response_code(403);
        echo json_encode(["error" => "Forbidden"]);
        exit;
    }
    
    // Get node info
    $nodeModel = $container->make(\App\Models\Node::class);
    $node = $nodeModel->findById($server["node_id"]);
    
    if (!$node) {
        http_response_code(404);
        echo json_encode(["error" => "Node not found"]);
        exit;
    }
    
    // Return node API info for WebSocket server
    header("Content-Type: application/json");
    echo json_encode([
        "success" => true,
        "user_id" => $userId,
        "role" => $role,
        "node_id" => $node["id"],
        "node_api_url" => $node["api_url"] ?? "",
        "node_api_token" => $node["api_token"] ?? "",
    ]);
});

$router->get("/servers/{id}/console/token", function ($params) use ($app, $container) {
    // Generate a temporary token for WebSocket connection
    $serverModel = $container->make(\App\Models\Server::class);
    $server = $serverModel->findById($params["id"]);
    
    if (!$server) {
        http_response_code(404);
        echo json_encode(["error" => "Server not found"]);
        exit;
    }
    
    $userId = $app->session()->get("user_id");
    $role = $app->session()->get("role");
    
    if ($role !== "owner" && $role !== "admin" && $server["user_id"] != $userId) {
        http_response_code(403);
        echo json_encode(["error" => "Forbidden"]);
        exit;
    }
    
    // Generate a short-lived token (5 minutes)
    $token = bin2hex(random_bytes(32));
    $expires = time() + 300;
    
    $app->db()->execute(
        "INSERT INTO console_tokens (token, server_uuid, user_id, expires_at, created_at) VALUES (?, ?, ?, FROM_UNIXTIME(?), NOW())",
        [$token, $server["uuid"], $userId, $expires]
    );
    
    header("Content-Type: application/json");
    echo json_encode([
        "success" => true,
        "token" => $token,
        "expires_at" => $expires,
        "server_uuid" => $server["uuid"]
    ]);
});