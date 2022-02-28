<?php

namespace Modules\Logs\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogReuest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'user' => 'required|string',
            'base_path' => 'required|string',
            'client_ip' => 'required|string',
            'host' => 'required|string',
            'query_string' => 'required|string',
            'request_uri' => 'required|string',
            'user_info' => 'required|string',
            'reason' => 'required|string',
            'message' => 'required|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }
}
