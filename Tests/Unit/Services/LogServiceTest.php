<?php

namespace Modules\Logs\Tests\Unit\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\Logs\Entities\Log;
use Modules\Logs\Repositories\LogRepository;
use Modules\Logs\Services\LogService;
use Modules\Logs\Services\StoreLogService;
use Modules\Logs\Validators\LogValidator;
use Tests\TestCase;

class LogServiceTest extends TestCase
{
    public function test_FindAll() : void
    {

        // given
        $logs = Log::all();
        $service = new LogService(new LogRepository(), new StoreLogService(new LogRepository));
        $responseCode = Response::HTTP_OK;
        $responseErrors = null;
        $expectedArray = [
            'content' => $logs, 'errors' => $responseErrors, 'code' => $responseCode,
        ];

        // when
        $response = $service->findAll();

        // then
        $this->assertEquals($expectedArray, $response);
    }

    public function test_FindById() : void
    {

        // given
        $id = 1;
        $log = Log::find($id);
        $service = new LogService(new LogRepository(), new StoreLogService(new LogRepository));
        $responseCode = Response::HTTP_OK;
        $responseErrors = null;
        $expectedArray = [
            'content' => $log, 'errors' => $responseErrors, 'code' => $responseCode,
        ];

        // when
        $response = $service->findById($id);

        // then
        $this->assertEquals($expectedArray, $response);
    }

    public function test_WhenCreateLog_ThenReturnOkResponseCode() : void
    {

        // given
        $service = new LogService(new LogRepository(), new StoreLogService(new LogRepository));
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

    public function test_WhenCreateLog_ThenReturnNotAcceptableResponseCode() : void
    {

        // given
        $service = new LogService(new LogRepository(), new StoreLogService(new LogRepository));
        $content = null;
        $log = [];
        $validator = Validator::make($log, LogValidator::$rules);
        $errors = $validator->errors();
        $responseCode = Response::HTTP_NOT_ACCEPTABLE;

        // when
        $response = $service->store($log);

        // then
        $this->assertEquals($content, $response['content']);
        $this->assertEquals($responseCode, $response['code']);
        $this->assertEquals($errors, $response['errors']);
    }
}
