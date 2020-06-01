<?php


namespace MeiliSearch\Contracts;


use Psr\Http\Message\ResponseInterface;

interface Http
{
//    public function get(): ResponseInterface;
    public function post($path, $body = null, $query = []):ResponseInterface;
//    public function put(): ResponseInterface;
//    public function patch(): ResponseInterface;
//    public function delete(): ResponseInterface;
}