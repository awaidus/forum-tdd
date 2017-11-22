<?php
function create($class, $arrtibutes = [], $times = null)
{
    return factory($class, $times)->create($arrtibutes);
}

function make($class, $arrtibutes = [], $times = null)
{
    return factory($class, $times)->make($arrtibutes);
}