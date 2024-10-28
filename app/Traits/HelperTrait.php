<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait HelperTrait
{
    public function validation(Request $request,array $rules,array $messages = [],array $niceNames =[])
    {
        $validator = Validator::make($request->all(), $rules, $messages, $niceNames);

        if ($validator->fails()) {
            $this->response_has_errors($validator->errors(),code:422);
            // throw new HttpResponseException(new Response(collect(['message' => 'field process !',"errors" => $validator->errors()]), 422));

        }
        // return false;
    }
    public function response_has_errors(mixed $errors =[],string $message = 'field process !',$code = 500)
    {
        throw new HttpResponseException(response(['message' => $message,"errors" => $errors], $code));

        // throw ValidationException::withMessages($errors)->status($code);
        // return response(['errors' => $errors,'message' => $message],$code);
        // }

    }
    public function error_log($msg,\Exception $exception){
        Log::error($msg,[
            'line' => __LINE__,
            'file' => __FILE__,
            'error_message' => $exception->getMessage(),
            'trace_error' => $exception->getTraceAsString(),
        ]);
    }
    public function apiExceptions($req,$exe)
    {
        if ($this->isModel($exe))
            return $this->responseModel();


        if ($this->isHttp($exe))
            return $this->responseHttp();


        return parent::render($req, $exe);
  }
  protected function isModel($exe){
        return $exe instanceof ModelNotFoundException;
}
protected function responseModel(){
        $this->response_has_errors('','this record not fount',Response::HTTP_NOT_FOUND);
}

    protected function isHttp($exe)
    {
        return $exe instanceof NotFoundHttpException;
}

    protected function responseHttp()
    {
        $this->response_has_errors('','this route not fount',Response::HTTP_NOT_FOUND);
    }
}

