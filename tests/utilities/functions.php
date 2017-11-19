<?php
function create($class, $arrtibutes = [])
{
    return factory($class)->create($arrtibutes);
}

function make($class, $arrtibutes = [])
{
    return factory($class)->make($arrtibutes);
}