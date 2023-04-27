-- remove / on the end so when its http://whatever-domain.com/
-- remove the last / so it looks like: http://whatever-domain.com
local url = "http://192.168.178.158";

-- Stuff
local matchid
local ct_score = 0
local t_score = 0
local hasRun = false
local endRun = false

-- Ranks
local ranks = {
    "Silver I",
    "Silver II",
    "Silver III",
    "Silver IV",
    "Silver Elite",
    "Silver Elite Master",
    "Gold Nova I",
    "Gold Nova II",
    "Gold Nova III",
    "Gold Nova Master",
    "Master Guardian I",
    "Master Guardian II",
    "Master Guardian Elite",
    "Distinguished Master Guardian",
    "Legendary Eagle",
    "Legendary Eagle Master",
    "Supreme",
    "Global Elite"
}

--GameMode function from Discord Ping lua https://aimware.net/forum/thread/133581
GameMode = function()
	local GameMode, GameType = tonumber(client.GetConVar('game_mode')), tonumber(client.GetConVar('game_type'))
	if GameMode == 1 and GameType == 0 then
		return 'Competitive'
	elseif GameMode == 2 and GameType == 0 then
		return 'Wingman'
    end
end

function sanitize_string(str)
    str = str:gsub("<[^>]+>", " ")
    str = str:gsub("<?[^>]+?>", " ")
    str = str:gsub("[\"'<>%?%[%]{}|\\%^%$,;#]", " ")
    return str
end

function convert_unicode(str)
    local result = ""
    for c in string.gmatch(str, ".[\128-\191]*") do
        if #c > 1 then
            c = utf8.char(utf8.codepoint(c))
        end
        result = result .. c
    end
    return result
end

callbacks.Register("Draw", function()
    if endRun then
        http.Get(url.."/assets/update_matchend.php?matchid="..matchid..
        "&score_t="..t_score..
        "&score_ct="..ct_score, function(response) 
            print(response) 
        end)
        endRun = false
    end
    if entities.GetLocalPlayer() == nil then
        hasRun = false
    elseif not hasRun then
        http.Get(url.."/assets/haship.php?ip="..engine.GetServerIP(), function(response)
            matchid = response
        end)
        ct_score = 0
        t_score = 0
        hasRun = true
    end
end)

callbacks.Register('FireGameEvent', function(event)
	if event:GetName() == 'round_announce_match_start' then
        if (GameMode() ~= 'Competitive' and GameMode() ~= 'Wingman') then
            return
        end

        http.Get(url.."/assets/insert_matchinfos.php?matchid="..matchid..
            "&map="..engine.GetMapName()..
            "&gamemode="..GameMode()..
            "&score_t=0&score_ct=0", function(response) 
                print(response) 
            end)

        local enemy = {}
        local lp = entities.GetLocalPlayer()
        if lp == nil then
            return
        end

        local players = entities.FindByClass("CCSPlayer")
        for i = 1, #players do
            table.insert(enemy, players[i])
        end

        for _, player in pairs(enemy) do
            if player:GetName() ~= "GOTV" and entities.GetPlayerResources():GetPropInt("m_iPing", player:GetIndex()) ~= 0 and player:IsPlayer() then
                local playerIndex = player:GetIndex()
                local playerName = sanitize_string(player:GetName())
                local playerInfo = client.GetPlayerInfo(playerIndex)
                local playerSteamID = playerInfo['SteamID']
                local playerWins = entities.GetPlayerResources():GetPropInt('m_iCompetitiveWins', playerIndex)
                local rankIndex = entities.GetPlayerResources():GetPropInt("m_iCompetitiveRanking", playerIndex)
                local playerRank = ranks[rankIndex] or "None"
                local playerTeam = player:GetTeamNumber()

                http.Get(url.."/assets/insert_start.php?name="..playerName..
                    "&matchid="..matchid..
                    "&steamid="..playerSteamID..
                    "&rank="..playerRank..
                    "&wins="..playerWins..
                    "&kills=0&deaths=0&assists=0&mvps=0&score=0&team="..playerTeam, function(response) 
                        print(response) 
                    end)
            end
        end
    end

    if event:GetName() == 'round_end' then
        if (GameMode() ~= 'Competitive' and GameMode() ~= 'Wingman') then
            return
        end

            local enemy = {}
            local lp = entities.GetLocalPlayer()
            if lp == nil then
                return
            end

            local players = entities.FindByClass("CCSPlayer")
            for i = 1, #players do
                table.insert(enemy, players[i])
            end

            for _, player in pairs(enemy) do
                if player:GetName() ~= "GOTV" and entities.GetPlayerResources():GetPropInt("m_iPing", player:GetIndex()) ~= 0 and player:IsPlayer() then
                    local playerIndex = player:GetIndex()
                    local playerInfo = client.GetPlayerInfo(playerIndex)
                    local playerSteamID = playerInfo['SteamID']
                    local playerKills = entities.GetPlayerResources():GetPropInt('m_iKills', playerIndex)
                    local playerAssists = entities.GetPlayerResources():GetPropInt('m_iAssists', playerIndex)
                    local playerDeaths = entities.GetPlayerResources():GetPropInt('m_iDeaths', playerIndex)
                    local playerMVPs = entities.GetPlayerResources():GetPropInt('m_iMVPs', playerIndex)
                    local playerScore = entities.GetPlayerResources():GetPropInt('m_iScore', playerIndex)
                    local playerTeam = player:GetTeamNumber()

                    http.Get(url.."/assets/update_users.php?matchid="..matchid..
                        "&steamid="..playerSteamID..
                        "&kills="..playerKills..
                        "&deaths="..playerDeaths..
                        "&assists="..playerAssists..
                        "&mvps="..playerMVPs..
                        "&score="..playerScore..
                        "&team="..playerTeam, function(response)
                            print(response)
                        end)
                end
            end
            local winnerTeam = event:GetInt('winner')
            local localTeam = entities.GetLocalPlayer():GetTeamNumber()

            if winnerTeam == localTeam then
                t_score = t_score + 1
            elseif winnerTeam ~= localTeam then
                ct_score = ct_score + 1
            end

            endRun = true;
    end

	if event:GetName() == 'cs_win_panel_match' then
        if (GameMode() ~= 'Competitive' and GameMode() ~= 'Wingman') then
            return
        end

        local enemy = {}
        local lp = entities.GetLocalPlayer()
        if lp == nil then
            return
        end

        local players = entities.FindByClass("CCSPlayer")
        for i = 1, #players do
            table.insert(enemy, players[i])
        end

        local enemy = entities.FindByClass("CCSPlayer")

        for _, player in pairs(enemy) do
            if player:GetName() ~= "GOTV" and entities.GetPlayerResources():GetPropInt("m_iPing", player:GetIndex()) ~= 0 and player:IsPlayer() then
                local playerIndex = player:GetIndex()
                local playerInfo = client.GetPlayerInfo(playerIndex)
                local playerSteamID = playerInfo['SteamID']
                local playerKills = entities.GetPlayerResources():GetPropInt('m_iKills', playerIndex)
                local playerAssists = entities.GetPlayerResources():GetPropInt('m_iAssists', playerIndex)
                local playerDeaths = entities.GetPlayerResources():GetPropInt('m_iDeaths', playerIndex)
                local playerMVPs = entities.GetPlayerResources():GetPropInt('m_iMVPs', playerIndex)
                local playerScore = entities.GetPlayerResources():GetPropInt('m_iScore', playerIndex)
                local playerTeam = player:GetTeamNumber()

                http.Get(url.."/assets/update_users.php?matchid="..matchid..
                    "&steamid="..playerSteamID..
                    "&kills="..playerKills..
                    "&deaths="..playerDeaths..
                    "&assists="..playerAssists..
                    "&mvps="..playerMVPs..
                    "&score="..playerScore..
                    "&team="..playerTeam, function(response)
                        print(response)
                    end)
            end
        end
        endRun = true
    end
end)
client.AllowListener('round_end')
client.AllowListener('round_announce_match_start')
client.AllowListener('cs_win_panel_match')