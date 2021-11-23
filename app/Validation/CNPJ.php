<?php

namespace App\Validation;

/**
 *
 */
class CNPJ
{
    /**
     * Método responsável por verificar se um CNPJ é válido
     * @param string $cnpj
     * @return boolean
     */
    public static function validar($cnpj)
    {
        //OBTEM OS NUMEROS DO CNPJ
        $cnpj = preg_replace('/\D/', '', $cnpj);

        //VERIFICA A QUANTIDADE DE CARACTERES
        if (strlen($cnpj) != 14) {
            return false;
        }
        //DIGITO VERIFICADOR
        $cnpjValidacao = substr($cnpj, 0, 12);

        $cnpjValidacao .= self::calcularDigitoVerificador($cnpjValidacao);
        $cnpjValidacao .= self::calcularDigitoVerificador($cnpjValidacao);

        //COMPARA O CNPJ ENVIADO COM O CNPJ CALCAULADO
        return $cnpjValidacao == $cnpj;
    }

    /**
     * Método responsável por calcular um dígito verificador com base em uma sequencia númerica
     * @param string $base
     * @return string
     */
    public static function calcularDigitoVerificador($base)
    {
        //AUXILIARES
        $tamanho = strlen($base);
        $multiplicador = 9;

        //SOMA DAS MULTIPLICAÇOES
        $soma = 0;

        //ITERA TODOS OS NUMEROS DA BASE (DIREITA -> ESQUERDA)
        /*
         * 123123121081
         * 1x6 2x7 3x8 1x9 2x2 3x3 1x4 2x5 1x6 0x7 3x8 1x9
        */
        for ($i = ($tamanho - 1); $i >= 0; $i--) {
            //SOMA DA MULTIPLICAÇAO ATUAL
            $soma += $base[$i] * $multiplicador;

            //AJUSTA O MULTIPLICADOR
            $multiplicador--;
            $multiplicador = $multiplicador < 2 ? 9 : $multiplicador;
        }
        //DEBUG
        echo "<pre>";
        print_r($soma);
        echo "</pre>";

        //RESTO DA DIVISAO = DIGITO VERIFICADOR
        return $soma % 11;
    }
}
