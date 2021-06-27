<?php

namespace DanieleFavi\Settings;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'value' => 'json'
    ];

    /**
     * Update an existing setting or store a new one if it not exists.
     *
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public function set($key, $value)
    {
        if ($setting = Setting::where('key', $key)->first()) {
            $setting->value = $value;
        } else {
            $setting = new Setting;
            $setting->key = $key;
            $setting->value = $value;
        }

        return $setting->save();
    }

    /**
     * Return the given setting or return the default if it not found.
     *
     * @param string $key
     * @param mixed $default|null
     * @return boolean
     */
    public function get($key, $default=null)
    {
        if ($setting = Setting::where('key', $key)->first()) {
            return $setting->value;
        }

        return $default;
    }

    /**
     * Increment a setting by the given amount (default=1).
     * If the setting does not exist it will be created.
     *
     * @param string $key
     * @param integer $amount
     * @return integer
     */
    public function inc($key, int $amount=1): int
    {
        $val = (int)$this->get($key, 0) + $amount;

        $this->set($key, $val);

        return $val;
    }

    /**
     * Decrement a setting by the given amount (default=1).
     * If the setting does not exist it will be created.
     *
     * @param string $key
     * @param integer $amount
     * @return integer
     */
    public function dec($key, int $amount=1): int
    {
        $val = (int)$this->get($key, 0) - $amount;

        $this->set($key, $val);

        return $val;
    }

    /**
     * Append to the given setting the given value.
     * If the setting does not exist it will be created.
     *
     * @param string $key
     * @param string|array $paramVal
     * @return void
     */
    public function attach(string $key, $paramVal)
    {
        if (empty($paramVal)) return $paramVal;

        $settingVal = $this->getDefaultValueForAttach($key, $paramVal);
        
        if (is_string($settingVal) || is_numeric($settingVal)) {
            $settingVal .= $paramVal;
        } else if (is_array($settingVal)) {
            if (empty($settingVal)) $settingVal = [];
            if (! is_array($paramVal)) $paramVal = [ $paramVal ];

            $settingVal = array_merge($settingVal, $paramVal);
        } else {
            throw new \Exception('The value passed to Setting@attach must be type of string or array.');
        }

        $this->set($key, $settingVal);

        return $settingVal;
    }

    /**
     * Gets the default value depending on the $paramVal that the user passed to the
     * function.
     *
     * @param string $key
     * @param string|array $paramVal
     * @return void
     */
    private function getDefaultValueForAttach(string $key, $paramVal)
    {
        $settingVal = $this->get($key);

        if (! empty($settingVal)) return $settingVal;

        if (is_string($paramVal) || is_numeric($paramVal)) {
            return '';
        } else if (is_array($paramVal)) {
            return [];
        }
        
        throw new \Exception('The value passed to Setting@attach must be type of string or array.');
    }

}
