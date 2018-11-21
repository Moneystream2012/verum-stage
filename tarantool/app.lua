#!/usr/bin/tarantool

json = require "json"

box.cfg {
  listen = 3301,
  log_level = 10
}

box.schema.user.passwd('admin', 'qweadsfvbhtsrafdvbhj1234565890')

box.once('users_space', function()
  local sp = box.schema.space.create('users')
  sp:create_index('user_id', { type = 'hash', parts = { 1, 'unsigned' } })
  sp:create_index('parent_id', { unique = false, parts = { 2, 'unsigned', 4, 'unsigned' } })
  sp:create_index('sponsor_id', { unique = false, parts = { 3, 'unsigned', } })
end)

box.once('users_active_binary_side_space', function()
  local sp = box.schema.space.create('users_active_binary_side')
  sp:create_index('primary', { parts = { 1, 'unsigned' } })
  sp:create_index('userid_level', { unique = false, parts = { 2, 'unsigned', 3, 'unsigned' } })
end)

users = box.space.users

function generate_users(count)
  count = count or 10
  for i = 1, count, 1 do
    --new_user_binary(i + 10000, 1, 'u' .. i + 10000)
    users:insert({ i, i - 1, 1, 0, 'u' .. i, 0, 0, 0, 0, 0 })
  end
end


function new_user_binary(user_id, sponsor_id, username, leg)
  local parent_id = sponsor_id
  repeat
    local userrow = users.index.parent_id:select({ parent_id, leg })
--    print(parent_id, sponsor_id, #userrow)
    if (#userrow == 1) then
      parent_id = userrow[1][1]
    end
  until #userrow == 0
  print('finish: ', user_id, parent_id, sponsor_id, leg, username)
  return users:insert({ user_id, parent_id, sponsor_id, leg, username, 0, 0, 0, 0, 0 })
  --  return user_active_binary_side(sponsor_id, leg)
end

--function user_active_binary_side(user_id, leg, level)
--  level = level or 1
--  local active_binary_side = box.space.users_active_binary_side
--  --    active_binary_side:auto_increment({ user_id, level, leg })
--
--  local rows = active_binary_side.index.userid_level:select { user_id, level }
--
--  if #rows == 0 then
--    active_binary_side:auto_increment({ user_id, level, leg })
--    return nil
--  end
--
--  if #rows == 1 and rows[1][4] ~= leg then
--
--    rows[2] = active_binary_side:auto_increment({ user_id, level, leg })
--    --        print(rows[2][1], rows[1][4], leg)
--  end
--
--  --print(#rows, level, user_id, leg)
--
--  if #rows == 2 and level == 1 then
--    local user = users:get(user_id)
--    if user ~= nil and user[3] ~= 0 then
--      return user_active_binary_side(user[3], user[4], level + 1)
--    end
--  end
--  if #rows == 2 and level == 2 then
--    if rows[1][5] == nil or rows[2][5] == nil then
--      active_binary_side:update(rows[1][1], { { '=', 5, true } })
--      active_binary_side:update(rows[2][1], { { '=', 5, true } })
--    end
--    return {
--      user_id = rows[1][2],
--      read = rows[1][5] or rows[2][5] or false
--    }
--  end
--
--  return nil
--end

function user_to_table(user)
  return {
    user_id = user[1],
    parent_id = user[2],
    sponsor_id = user[3],
    username = user[5],
    point_left_week = user[8],
    point_right_week = user[9],
    rank = user[10],
    deposits = user[11],
    level = 0,
    children = {},
  }
end

function get_points_score(user_id)
  local user = users:get(user_id)
  if not user then
    return {
      left_total = 0,
      right_total = 0,
      left_week = 0,
      right_week = 0
    }
  end
  return {
    left_total = user[6],
    right_total = user[7],
    left_week = user[8],
    right_week = user[9]
  }
end

function set_user_best_plan(user_id, best_plan)
  print('=====================================')
  print("set_user_best_plan: => ", user_id, best_plan)
  return users:update({ user_id }, { { '=', 10, best_plan } })
end

function add_user_deposit(user_id, deposit_id, plan)
  local user = users:get(user_id)
  local deposits = user[11] or {}
  deposits["d" .. deposit_id] = plan
  return users:update({ user_id }, { { '=', 11, deposits } })
end

function rm_user_deposit(user_id, deposit_id)
  local user = users:get(user_id)
  local deposits = user[11] or {}
  deposits["d" .. deposit_id] = nil
  return users:update({ user_id }, { { '=', 11, deposits } })
end

--function get_count_rang_products_binary(user_id)
--  local count = {
--    rank = { 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 },
--    products = { 0, 0, 0, 0, 0 }
--  }
--  local stack = { user_id }
--  while #stack > 0 do
--    local user_id = table.remove(stack)
--    local items = users.index.parent_id:select(user_id)
--    for i, childrow in ipairs(items) do
--      count.rank[tonumber(childrow[10])] = (count.rank[tonumber(childrow[10])] or 0) + 1
--      if childrow[11] then
--        for i, plan in pairs(childrow[11]) do
--          if plan ~= nil then
--            count.products[tonumber(plan)] = count.products[tonumber(plan)] + 1
--          end
--        end
--      end
--      table.insert(stack, childrow[1])
--    end
--  end
--  return count
--end

--[[function get_count_rang_products_referrals(user_id)
    local counts = {
        {
            rank = { 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 },
            products = { 0, 0, 0, 0, 0 }
        },
        {
            rank = { 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 },
            products = { 0, 0, 0, 0, 0 }
        }
    }

    local stack = {
        {
            id = user_id,
            leg = nil
        }
    }
    while #stack > 0 do
        local user = table.remove(stack)
        local items = users.index.parent_id:select(user.id)

        for i, childrow in ipairs(items) do
            if user.leg == nil then
                user.leg = childrow[4]
            end
            if user.leg ~= childrow[4] then
                user.leg = childrow[4]
            end
            if childrow[3] == user_id then
                counts[user.leg + 1].rank[tonumber(childrow[10])] = (counts[user.leg + 1].rank[tonumber(childrow[10])] or 0) + 1
                if childrow[11] then
                    for i, plan in pairs(childrow[11]) do
                        if plan ~= nil then
                            counts[user.leg + 1].products[tonumber(plan)] = counts[user.leg + 1].products[tonumber(plan)] + 1
                        end
                    end
                end
            end

            table.insert(stack, {
                id = childrow[1],
                leg = user.leg
            })
        end
    end
    return counts
end]]

--[[function is_active_binary_side(user_id)
    local count = 0
    local max_depth = 2
    local stack = {
        {
            id = user_id,
            level = 0
        }
    }
    while #stack > 0 do
        local user = table.remove(stack)
        local items = users.index.parent_id:select(user.id)
        for i, childrow in ipairs(items) do
            if user.level == max_depth then break end
            count = count + 1
            table.insert(stack, { id = childrow[1], level = user.level + 1 })
        end
    end
    return count
end]]

function get_parent_by_user_id(user_id)
  local userrow = users:get(user_id)
  return user_to_table(users:get(userrow[2]))
end

--function get_sponsor_by_user_id(user_id)
--    local userrow = users:get(user_id)
--    return user_to_table(users:get(userrow[3]))
--end

function user_point_calculate(user_id, point)
  local user = users:get(user_id)
  if user[2] == 0 then return
  end
  repeat
    user = users:update({ user[2] }, { { '+', user[4] == 0 and 6 or 7, point }, { '+', user[4] == 0 and 8 or 9, point } })
  until user[2] == 0
end

function user_point_calculate_fix(user_id, point, not_users_id)
  local user = users:get(user_id)
  if user[2] == 0 then return
  end
  repeat
    print("start: ")
    print(user_id, user[2], point)
    if has_value(not_users_id, user[2]) then
      print("NOT: ", user[2])
      user = users:get(user[2])
    else
      print("YES: ", user[2])
      user = users:update({ user[2] }, { { '+', user[4] == 0 and 6 or 7, point }, { '+', user[4] == 0 and 8 or 9, point } })
      --        user = users:get(user[2])
    end
  until user[2] == 0
end

function has_value(tab, val)
  for index, value in ipairs(tab) do
    if value == val then
      return true
    end
  end

  return false
end

function binary_compute()
  local data = {}
  for i, user in ipairs(users:select()) do
    local reward = user[8]
    if user[10] > 0 then
      if user[8] > user[9] then
        reward = user[9]
        users:update({ user[1] }, { { '-', 8, user[9] }, { '=', 9, 0 } })
      elseif user[8] < user[9] then
        users:update({ user[1] }, { { '=', 8, 0 }, { '-', 9, user[8] } })
      elseif user[8] == user[9] then
        users:update({ user[1] }, { { '=', 8, 0 }, { '=', 9, 0 } })
      end
      table.insert(data, { user[1], user[8], user[9], reward })
    else
      users:update({ user[1] }, { { '=', 8, 0 }, { '=', 9, 0 } })
    end
  end

  return { data }
end

function binary_compute_fix(users_id)
  local data = {}
  for i, user in ipairs(users:select()) do
    local reward = user[8]
    if not has_value(users_id, user[1]) then
      if user[10] > 0 then
        print("YES:", user[1])
        if user[8] > user[9] then
          reward = user[9]
          users:update({ user[1] }, { { '-', 8, user[9] }, { '=', 9, 0 } })
        elseif user[8] < user[9] then
          users:update({ user[1] }, { { '=', 8, 0 }, { '-', 9, user[8] } })
        elseif user[8] == user[9] then
          users:update({ user[1] }, { { '=', 8, 0 }, { '=', 9, 0 } })
        end
        table.insert(data, { user[1], user[8], user[9], reward })
      else
        users:update({ user[1] }, { { '=', 8, 0 }, { '=', 9, 0 } })
      end
    else
      print("NOT:", user[1])
    end
  end

  return { data }
end

function binary_compute2()
  local data = {}
  for i, user in ipairs(users:select()) do
    users:update({ user[1] }, { { '=', 8, user[6] }, { '=', 9, user[7] } })
    if user[10] > 0 then
      if user[6] > user[7] then
        users:update({ user[1] }, { { '-', 8, user[7] }, { '=', 9, 0 } })
      elseif user[6] < user[7] then
        users:update({ user[1] }, { { '=', 8, 0 }, { '-', 9, user[6] } })
      elseif user[6] == user[7] then
        users:update({ user[1] }, { { '=', 8, 0 }, { '=', 9, 0 } })
      end
    else
      users:update({ user[1] }, { { '=', 8, 0 }, { '=', 9, 0 } })
    end
  end

  return { data }
end

function get_user_binary_tree(user_id)
  local userrow = users:get(user_id)
  local rootuser = user_to_table(userrow)
  rootuser.is_root = true
  local stack = { rootuser }
  local max_depth = 3
  local users_id = {}
  while #stack > 0 do
    local user = table.remove(stack)
    table.insert(users_id, user.user_id)
    local items = users.index.parent_id:select(user.user_id)
    if #items == 2 and items[1][4] == 1 then
      items[1], items[2] = items[2], items[1]
    end
    for i, childrow in ipairs(items) do
      local child = user_to_table(childrow)
      if user.level == max_depth then break
      end
      child.level = user.level + 1
      if #items == 1 then
        if childrow[4] == 1 then
          user.children[2], user.children[1] = child, { children = {} }
        else
          user.children[1], user.children[2] = child, { children = {} }
        end
      else
        user.children[i] = child
      end
      table.insert(stack, child)
    end
  end
  -- local count = get_count_rang_products_binary(user_id)
  return {
    users = rootuser,
    -- count = count,
    users_id = users_id,
  }
end

function get_user_binary_full_json(user_id)
  local function user_to_table_json(user)
    return {
      user_id = user[1],
      name = user[5],
      level = 0,
      point_left_week = user[8],
      point_right_week = user[9],
      children = {},
    }
  end

  local userrow = users:get(user_id)
  local rootuser = user_to_table_json(userrow)
  local stack = { rootuser }
  local max_depth = 600
  while #stack > 0 do
    local user = table.remove(stack)
    local items = users.index.parent_id:select(user.user_id)
    if #items == 2 and items[1][4] == 1 then
      items[1], items[2] = items[2], items[1]
    end
    if #items == 0 and user_id == user.user_id then
      user.children = {
        {
          name = '-'
        },
        {
          name = '-'
        }
      }
    end
    for i, childrow in ipairs(items) do
      local child = user_to_table_json(childrow)
      if user.level == max_depth then break
      end
      child.level = user.level + 1

      if #items == 1 then
        if childrow[4] == 1 then
          user.children[2], user.children[1] = child, {
            name = '-'
          }
        else
          user.children[1], user.children[2] = child, {
            name = '-'
          }
        end
      else
        user.children[i] = child
      end
      table.insert(stack, child)
    end
  end

  return json.encode(rootuser)
end

--[[function get_user_position_leg(sponsor_id)
    local counts = { 0, 0 }
    local stack = {
        {
            id = sponsor_id,
            leg = nil
        }
    }
    while #stack > 0 do
        local user = table.remove(stack)
        local items = users.index.parent_id:select(user.id)

        for i, childrow in ipairs(items) do
            if user.leg == nil then
                user.leg = childrow[4]
            end
            if user.leg ~= childrow[4] then
                user.leg = childrow[4]
            end

            if childrow[3] == sponsor_id then
                counts[user.leg + 1] = counts[user.leg + 1] + 1
            end

            table.insert(stack, {
                id = childrow[1],
                leg = user.leg
            })
        end
    end
    return counts[1] > counts[2] and 1 or 0
end]]

function is_user_id_binary(root_id, user_id)
  local is_user = false
  local stack = { root_id }
  while #stack > 0 do
    local stack_user_id = table.remove(stack)
    if (stack_user_id == user_id and root_id ~= user_id) then
      is_user = true
      break
    end
    local items = users.index.parent_id:select(stack_user_id)
    for i, childrow in ipairs(items) do
      table.insert(stack, childrow[1])
    end
  end
  return is_user
end

function is_user_id_unilevel(root_id, user_id)
  local max_depth = 8
  local stack = {
    {
      id = root_id,
      level = 0
    }
  }
  local level
  while #stack > 0 do
    local user = table.remove(stack)
    if (user.id == user_id and root_id ~= user_id) then
      level = user.level
      break
    end
    local items = users.index.sponsor_id:select(user.id)
    for i, childrow in ipairs(items) do
      if user.level == max_depth then break
      end
      table.insert(stack, {
        id = childrow[1],
        level = user.level + 1
      })
    end
  end
  return level or nil
end

--function has_user_id(user_id)
--    return users:get(user_id) and true or false
--end

--start_time = os.clock()
--calculateTree(500000, 5)
--get_user_binary_tree(1)
--end_time = os.clock()
--print('insert done in ' .. end_time - start_time .. ' seconds')
