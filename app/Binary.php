<?php

namespace App;

class Binary
{
    public static function getPointsByUserId($user_id)
    {
        return (object) cache()->store('tarantool')->getCall('get_points_score', [$user_id])[0];
    }
}
