<?php

namespace Modules\Logs\Tests\Unit\Repositories;

use SilenceOnTheWire\Logs\Entities\Log;
use SilenceOnTheWire\Logs\Repositories\LogRepository;
use Tests\TestCase;

class LogRepositoryTest extends TestCase
{
    public function test_FindAllLogs() : void
    {

        // given
        $logs = Log::all();
        $repository = new LogRepository();

        // when
        $currentLogs = $repository->findAll();

        // then
        $this->assertEquals($logs, $currentLogs);
    }

    public function test_FindLog() : void
    {

        // given
        $id = 1;
        $log = Log::find($id);
        $repository = new LogRepository();

        // when
        $currentLog = $repository->findById($id);

        // then
        $this->assertEquals($log, $currentLog);
    }

    public function test_StoreLog() : void
    {

        // given
        $currentLog = null;
        $repository = new LogRepository();
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

        // when
        $currentLog = $repository->store($log);

        // then
        $this->assertDatabaseHas('logs', ['user' => $log['user'],]);
        $this->assertDatabaseHas('logs', ['base_path' => $log['base_path'],]);
        $this->assertDatabaseHas('logs', ['client_ip' => $log['client_ip'],]);
        $this->assertDatabaseHas('logs', ['host' => $log['host'],]);
        $this->assertDatabaseHas('logs', ['query_string' => $log['query_string'],]);
        $this->assertDatabaseHas('logs', ['request_uri' => $log['request_uri'],]);
        $this->assertDatabaseHas('logs', ['user_info' => $log['user_info'],]);
        $this->assertDatabaseHas('logs', ['message' => $log['message'],]);

        $this->assertEquals($log['user'], $currentLog->user);
        $this->assertEquals($log['base_path'], $currentLog->base_path);
        $this->assertEquals($log['client_ip'], $currentLog->client_ip);
        $this->assertEquals($log['host'], $currentLog->host);
        $this->assertEquals($log['query_string'], $currentLog->query_string);
        $this->assertEquals($log['request_uri'], $currentLog->request_uri);
        $this->assertEquals($log['user_info'], $currentLog->user_info);
        $this->assertEquals($log['message'], $currentLog->message);
        $this->assertEquals($log['reason'], $currentLog->reason);
    }
}
