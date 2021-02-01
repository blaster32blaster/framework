<?php 

/**
 * handle home screen
 */
class home
{
    /**
     * return home page
     *
     * @return void
     */
    public function handle()
    {
        return file_get_contents('js/home.js');
    }
}