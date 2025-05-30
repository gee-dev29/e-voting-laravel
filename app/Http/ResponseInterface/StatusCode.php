<?php

namespace App\Http\ResponseInterface;

class StatusCode
{
  const OK = 200;
  const CREATED = 201;
  const NO_CONTENT = 204;
  const BAD_REQUEST = 400;
  const NOT_FOUND = 404;
  const INTERNAL_SERVER_ERROR = 500;
}
