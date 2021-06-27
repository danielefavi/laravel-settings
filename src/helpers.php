<?php

if (! function_exists('settings')) {
    /**
     * Return the Setting instance from the app service container.
     *
     * @return DanieleFavi\Settings\Setting
     */
    function settings(): DanieleFavi\Settings\Setting
    {
        return app('settings');
    }
}