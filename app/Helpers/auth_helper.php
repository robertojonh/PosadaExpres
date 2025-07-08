<?php

function auth_id()
{
    /* return 6; */
    return session()->get('user_id');
}

function type()
{
    return session()->get('type');
}

function tipo()
{
    return session()->get('tipo');
}

function es_editor()
{
    return in_array(type(), ['administrador', 'ejecutora', 'solicitante']);
}

function es_revisor()
{
    return in_array(type(), ['revision']);
}

function es_consultor()
{
    return in_array(type(), ['revision', 'consulta', 'admin', 'ejecutora']);
}
