<?php


namespace MeiliSearch\Contracts;


interface Http
{
    public function get($path, $query = []);
    public function post(string $path, $body = null, $query = []);
    public function put();
    public function patch();
    public function delete();
}