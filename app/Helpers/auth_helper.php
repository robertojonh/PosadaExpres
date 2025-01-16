<?php

function auth_id()
{
    /* return 6; */
    return session()->get('user_id');
}