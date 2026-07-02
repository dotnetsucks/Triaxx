<?php
include('../../config/db.php');
date_default_timezone_set('UTC');
$mysqli->query("SET time_zone = '+00:00'");

if (!isset($_GET['ID'])) {
    die('no id found');
}

$id = (int)$_GET['ID'];

$stmt = $mysqli->prepare("SELECT * FROM games WHERE gid = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$game = $stmt->get_result()->fetch_assoc();

if (!$game) {
    die('game not found');
}

$lastping = strtotime($game['lastping']);
$alive = ($game['status'] == 1 && $lastping >= time() - 21);

if (!$alive && $game['status'] == 1) {
    $stmt = $mysqli->prepare("UPDATE games SET status = 0 WHERE gid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $game['status'] = 0;
    $alive = false;
}

if ($alive) {
    $port = (int)$game['port'];
} else {
    require('../Soap.php');

    $rcc = new GetALiveAndSoap("26.72.83.255", 799);

    $port = rand(5000, 10000);

    $jobid = "host_gid_" . $id . "_" . bin2hex(random_bytes(10));

    $luaScript = $luaScript = '
game:Load("http://26.72.83.255/api/game/rbxl/' . $id . '.rbxl")
local NetworkServer = game:service("NetworkServer")
NetworkServer:start(' . $port . ')
local RunService = game:service("RunService")
RunService:run()

function characterRessurection(player)
    if player.Character then
        local humanoid = player.Character.Humanoid
        humanoid.Died:connect(function()
            print(player.Name .. " died")
            wait(5)
            print(player.Name .. " character spawned")
            player:LoadCharacter()
        end)
    end
end

game:service("Players").PlayerAdded:connect(function(player)
    print(player.Name.. " joined ' . $port . '")
    player.Changed:connect(function(name)
        if name == "Character" then
            characterRessurection(player)
        end
    end)

    player.Chatted:connect(function(msg)
        if msg == "!reset" then
            if player.Character then
                local hum = player.Character:FindFirstChild("Humanoid")
                if hum then
                    print(player.Name .. " resetted")
                    hum.Health = 0
                end
            end
        end
        if player.Name == "Admin" then
            --pwn/kill yk
            if msg:sub(1,4) == "!pwn" then
                local targetName = msg:sub(6)

                for _, p in pairs(game.Players:GetPlayers()) do
                    if p.Name == targetName and p.Character then
                        local hum = p.Character:FindFirstChild("Humanoid")
                        if hum then
                            hum.Health = 0
                        end
                    end
                end
            end
            
            -- CRUSH BRUTALLY
            if msg:sub(1,6) == "!crush" then
                local targetName = msg:sub(8)

                for _, p in pairs(game.Players:GetPlayers()) do
                    if p.Name == targetName and p.Character then
                        local torso = p.Character:FindFirstChild("Torso")
                        if torso then
                            local boulder = Instance.new("Part")
                            boulder.Anchored = false
                            boulder.Size = Vector3.new(50,50,50)
                            boulder.Parent = game.Workspace
                            boulder.Shape = "Ball"
                            -- boulder.Shape = Enum.PartTypes.Ball
                            boulder.Position = torso.Position + Vector3.new(0, 100, 0)

                            wait(10)

                            boulder:Remove()
                        end
                    end
                end
            end

            -- boom.
            if msg:sub(1,8) == "!explode" then
                local targetName = msg:sub(10)

                for _, p in pairs(game.Players:GetPlayers()) do
                    if p.Name == targetName and p.Character then
                        local torso = p.Character:FindFirstChild("Torso")
                        if torso then
                            local boom = Instance.new("Explosion")
                            boom.Position = torso.Position
                            boom.BlastRadius = 10
                            boom.BlastPressure = 500000
                            boom.Parent = game.Workspace
                            wait(5)
                            boom:Remove()
                        end
                    end
                end
            end

            if msg:sub(1,5) == "!kick" then
                local targetName = msg:sub(7)

                for _, p in pairs(game.Players:GetPlayers()) do
                    if p.Name == targetName and p.Character then
                        game.Players:FindFirstChild(targetname):Kick()
                    end
                end
            end

            if msg == "!shutdown" then
                local msg = Instance.new("Message")
                msg.Parent = game.Workspace
                msg.Text = "Shutting down in 5..."
                wait(1)
                msg.Text = "Shutting down in 4..."
                wait(1)
                msg.Text = "Shutting down in 3..."
                wait(1)
                msg.Text = "Shutting down in 2..."
                wait(1)
                msg.Text = "Shutting down in 1..."
                wait(1)
                print("commencing shutdown - jobid: ' . $jobid . ' port: ' . $port . ' - command")
                print("calling closeserv - jobid: ' . $jobid . '")
                game:HttpGet("http://26.72.83.255/api/game/closeserv.ashx?gid=' . $id . '&jobid=' . $jobid . '")
                print("closeserv done")
                NetworkServer:Stop()
                return 0
            end
        end
    end)

end)

while true do
    game:HttpGet("http://26.72.83.255/api/game/ping.ashx?ID=' . $id . '")
    print("ping - jobid: ' . $jobid . ' port: ' . $port . '")
    if #game.Players:GetChildren() == 0 then
        print("shutdown - jobid: ' . $jobid . ' port: ' . $port . ' - no players - 20 secs")
        wait(20)
        if #game.Players:GetChildren() == 0 then
            print("commencing shutdown - jobid: ' . $jobid . ' port: ' . $port . ' - no players")
            print("calling closeserv - jobid: ' . $jobid . '")
            game:HttpGet("http://26.72.83.255/api/game/closeserv.ashx?gid=' . $id . '&jobid=' . $jobid . '")
            print("closeserv done")
            NetworkServer:Stop()
            return 0
        end
    end
    wait(20)
end
';

    $response = $rcc->execScript($luaScript, $jobid, 2147483647);

    $stmt = $mysqli->prepare("UPDATE games SET status = ?, port = ?, jobid = ?, lastping = FROM_UNIXTIME(?) WHERE gid = ?");
    $status = 1;
    $now = time();

    $stmt->bind_param("iisii", $status, $port, $jobid, $now, $id);
    $stmt->execute();
}
?>