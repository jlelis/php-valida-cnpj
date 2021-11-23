<?php

namespace App\Validation;

/**
 *
 */
class CPF
{
    /**
     * Método responsável por verificar se um CPF é válido
     * @param string $cpf
     * @return boolean
     */
    public static function validar($cpf)
    {
        //OBTEM OS NUMEROS DO CPF
        $cpf = preg_replace('/\D/', '', $cpf);

        //VERIFICA A QUANTIDADE DE CARACTERES
        if (strlen($cpf) != 11) {
            return false;
        }
        //DIGITO VERIFICADOR
        $cpfValidacao = substr($cpf, 0, 9);
        $cpfValidacao .= self::calcularDigitoVerificador($cpfValidacao);
        $cpfValidacao .= self::calcularDigitoVerificador($cpfValidacao);

        //COMPARA O CPF ENVIADO COM O CPF CALCAULADO
        return $cpfValidacao == $cpf;
    }

    /**
     * Método responsável por calcular um dígito verificador com base em uma sequencia númerica
     * @param string $base
     * @return string
     */
    public static function calcularDigitoVerificador($base)
    {
        //DEBUG
        echo "<pre>";
        print_r("CPF: " . $base);
        print_r("CPF: " . strlen($base));
        echo "</pre>";
        /*
         * 352.299.840-58
         * 3x10 5x9 2x8 2x7 9x6 9x5 8x4 4x3 0x2
         * */
        //AUXILIARES
        $tamanho = strlen($base);
        $multiplicador = $tamanho + 1;

        //SOMA
        $soma = 0;
        //INTERAÇAO DOS NUMEROS CPF
        for ($i = 0; $i < $tamanho; $i++) {
            $soma += $base[$i] * $multiplicador;
            $multiplicador--;
        }
        //RESTO DA DIVISAO
        $resto = $soma % 11;

        //RETORNA O DIGITO VERIFICADOR

        return $resto > 1 ? 11 - $resto : 0;
    }
}
