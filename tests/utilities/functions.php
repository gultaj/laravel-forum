<?php

function create($class, $attributes = [])
{
    return factory($class)->create($attributes);
}

function create_testing($class, $attributes = [])
{
    return factory($class)->states('testing')->create($attributes);
}

function make($class, $attributes = [])
{
    return factory($class)->make($attributes);
}

function make_testing($class, $attributes = [])
{
    return factory($class)->states('testing')->make($attributes);
}