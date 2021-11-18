<?php

namespace App\Http\Utils;

class Response
{

    /**
     * Função para realizar retornos de request com sucesso
     * @param array $data Informações do retorno
     * @param string $msg Mensagem de retorno
     * @param int $status Status do retorno
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = [], $msg = '', $status = 200)
    {
        $response = [
            'data' => ($data) ?? [],
            'msg' => ($msg) ? $msg : ''
        ];

        return response()->json($response, $status);
    }

    /**
     * Função para realizar retornos de request com erros
     * @param array $data Informações do retorno
     * @param string $msg Mensagem de retorno
     * @param array $errors Array com os erros
     * @param int $status Status do retorno
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($data = [], $msg = '', $errors = [], $status = 400)
    {
        $msg_error = [];
        if (!empty($errors)) {
            foreach ($errors as $key => $value) {
                $msg_error[$key] = $value;
            }
        }

        $response = [
            'data' => ($data) ?? [],
            'msg' => ($msg) ? $msg : '',
            'errors' => $msg_error
        ];

        return response()->json($response, $status);
    }
}
