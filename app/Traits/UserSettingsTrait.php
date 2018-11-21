<?php

namespace App\Traits;

trait UserSettingsTrait
{
    public function getSetting($value, $default = null)
    {
        return array_get($this->settings, $value, $default);
    }

    public function setSetting(array $data = [])
    {
        $this->settings = array_where(array_replace($this->settings ?? [], $data), function ($value) {
            return $value != '';
        });
        $this->save();
    }

    /**
     * @param array|string $keys
     *
     * @return bool
     */
    public function hasSetting($keys):bool
    {
        return array_has($this->settings, $keys);
    }

    /**
     * @param array|string $keys
     */
    public function forgetSetting($keys)
    {
        $this->settings = array_except($this->settings, $keys);
        $this->save();
    }
}
