<?php

namespace Modules\Logs\Tests\Unit\Services;

use Illuminate\Http\Response;
use Modules\Logs\Repositories\LogRepository;
use Modules\Logs\Services\StoreLogService;
use Tests\TestCase;

class StoreLogServiceTest extends TestCase
{
    public function test_StoreLog() : void
    {

        // given
        $service = new StoreLogService(new LogRepository());
        $log = [
            'user' => 'user',
            'base_path' => '/',
            'client_ip' => '127.0.0.1',
            'host' => 'http://localhost',
            'query_string' => 'name=hello_world',
            'request_uri' => '/create',
            'user_info' => 'user_info',
            'message' => 'hello',
            'reason' => 'world',
        ];
        $errors = null;
        $responseCode = Response::HTTP_OK;

        // when
        $response = $service->store($log);

        // then
        $this->assertDatabaseHas('logs', ['user' => $log['user'],]);
        $this->assertDatabaseHas('logs', ['base_path' => $log['base_path'],]);
        $this->assertDatabaseHas('logs', ['client_ip' => $log['client_ip'],]);
        $this->assertDatabaseHas('logs', ['host' => $log['host'],]);
        $this->assertDatabaseHas('logs', ['query_string' => $log['query_string'],]);
        $this->assertDatabaseHas('logs', ['request_uri' => $log['request_uri'],]);
        $this->assertDatabaseHas('logs', ['user_info' => $log['user_info'],]);
        $this->assertDatabaseHas('logs', ['message' => $log['message'],]);

        $this->assertEquals($log['user'], $response['content']->user);
        $this->assertEquals($log['base_path'], $response['content']->base_path);
        $this->assertEquals($log['client_ip'], $response['content']->client_ip);
        $this->assertEquals($log['host'], $response['content']->host);
        $this->assertEquals($log['query_string'], $response['content']->query_string);
        $this->assertEquals($log['request_uri'], $response['content']->request_uri);
        $this->assertEquals($log['user_info'], $response['content']->user_info);
        $this->assertEquals($log['message'], $response['content']->message);
        $this->assertEquals($log['reason'], $response['content']->reason);

        $this->assertEquals($responseCode, $response['code']);
        $this->assertEquals($errors, $response['errors']);
    }
}
